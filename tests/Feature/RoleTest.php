<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Videos\Pages\ListVideos;
use App\Filament\Resources\Videos\VideoResource;
use App\Filament\Widgets\AdminGlobalStats;
use App\Filament\Widgets\AdminUserVideosStats;
use App\Filament\Widgets\MyVideosStats;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_factory_state_marks_user_as_admin(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($user->isAdmin());
        $this->assertSame(UserRole::Admin, $admin->role);
    }

    public function test_regular_user_cannot_stream_or_download_another_users_video(): void
    {
        $video = $this->makeVideo();
        $intruder = User::factory()->create();

        $this->actingAs($intruder)->get(route('videos.stream', $video))->assertForbidden();
        $this->actingAs($intruder)->get(route('videos.download', $video))->assertForbidden();
    }

    public function test_admin_can_stream_and_download_any_users_video(): void
    {
        $video = $this->makeVideo();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('videos.stream', $video))->assertOk();
        $this->actingAs($admin)->get(route('videos.download', $video))->assertOk();
    }

    public function test_video_list_only_shows_own_videos_to_regular_users(): void
    {
        $mine = $this->makeVideo();
        $other = $this->makeVideo();

        $this->actingAs($mine->user);

        Livewire::test(ListVideos::class)
            ->assertCanSeeTableRecords([$mine])
            ->assertCanNotSeeTableRecords([$other]);
    }

    public function test_video_list_shows_all_videos_to_admins(): void
    {
        $first = $this->makeVideo();
        $second = $this->makeVideo();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        Livewire::test(ListVideos::class)
            ->assertCanSeeTableRecords([$first, $second]);
    }

    public function test_video_navigation_label_changes_by_role(): void
    {
        $this->actingAs(User::factory()->create());
        $this->assertSame('Mis videos', VideoResource::getNavigationLabel());

        $this->actingAs(User::factory()->admin()->create());
        $this->assertSame('Videos turísticos', VideoResource::getNavigationLabel());
    }

    public function test_user_resource_is_admin_only(): void
    {
        $this->actingAs(User::factory()->create());
        $this->assertFalse(UserResource::canViewAny());

        $this->actingAs(User::factory()->admin()->create());
        $this->assertTrue(UserResource::canViewAny());
    }

    public function test_widget_visibility_depends_on_role(): void
    {
        $this->actingAs(User::factory()->create());
        $this->assertTrue(MyVideosStats::canView());
        $this->assertFalse(AdminGlobalStats::canView());
        $this->assertFalse(AdminUserVideosStats::canView());

        $this->actingAs(User::factory()->admin()->create());
        $this->assertFalse(MyVideosStats::canView());
        $this->assertTrue(AdminGlobalStats::canView());
        $this->assertTrue(AdminUserVideosStats::canView());
    }

    public function test_admin_user_videos_widget_scopes_metrics_to_selected_user(): void
    {
        $target = User::factory()->create();
        $this->makeVideo($target);
        $this->makeVideo();
        $this->makeVideo();

        $widget = new AdminUserVideosStats;
        $widget->userId = $target->id;

        $metrics = $widget->metrics();

        $this->assertSame('1', $metrics[0]['value']);
        $this->assertSame('1:30', $metrics[1]['value']);
    }

    public function test_admin_user_videos_widget_renders_for_admin(): void
    {
        $target = User::factory()->create();
        $this->makeVideo($target);

        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(AdminUserVideosStats::class)
            ->set('userId', $target->id)
            ->assertSet('userId', $target->id)
            ->assertSee('Estadísticas por usuario');
    }

    public function test_admin_can_render_the_users_list(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(ListUsers::class)->assertOk();
    }

    public function test_admin_can_create_a_user_through_the_panel_with_hashed_password(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(CreateUser::class)
            ->fillForm([
                'name' => 'Nuevo Usuario',
                'email' => 'nuevo@turiplay.com',
                'password' => 'secret123',
                'role' => UserRole::Admin->value,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $user = User::where('email', 'nuevo@turiplay.com')->firstOrFail();

        $this->assertSame(UserRole::Admin, $user->role);
        $this->assertNotSame('secret123', $user->password);
        $this->assertTrue(Hash::check('secret123', $user->password));
    }

    private function makeVideo(?User $user = null): Video
    {
        Storage::fake('local');
        $user ??= User::factory()->create();

        $path = 'videos/'.$user->id.'-'.uniqid().'.mp4';
        Storage::disk('local')->put($path, 'fake-video-bytes');

        return Video::create([
            'user_id' => $user->id,
            'title' => 'Video de '.$user->name,
            'description' => 'Descripción de prueba.',
            'location' => 'Lima',
            'duration_seconds' => 90,
            'mime_type' => 'video/mp4',
            'size_bytes' => 16,
            'path' => $path,
        ]);
    }
}
