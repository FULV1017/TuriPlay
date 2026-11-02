<?php

namespace Tests\Feature;

use App\Filament\Resources\Videos\Pages\EditVideo;
use App\Models\User;
use App\Models\Video;
use App\Services\VideoMetadata;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PublicVideoTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_opted_in_videos_appear_in_public_gallery(): void
    {
        $private = $this->video();
        $public = $this->video(['is_public' => true, 'title' => 'Video público']);

        $this->assertFalse($private->fresh()->is_public);

        $this->get('/explorar')
            ->assertOk()
            ->assertSee('Video público')
            ->assertDontSee($private->title);

        $this->get('/explorar/'.$public->id)->assertOk()->assertSee('Video público');
        $this->get('/explorar/'.$private->id)->assertNotFound();
    }

    public function test_guest_can_stream_only_public_videos_but_cannot_download_them(): void
    {
        $private = $this->video();
        $public = $this->video(['is_public' => true]);

        $this->get(route('videos.stream', $public))->assertOk();
        $this->get(route('videos.stream', $private))->assertForbidden();
        $this->get(route('videos.download', $public))->assertForbidden();
    }

    public function test_authenticated_other_user_cannot_stream_a_private_video(): void
    {
        $private = $this->video();

        $this->actingAs(User::factory()->create())
            ->get(route('videos.stream', $private))
            ->assertForbidden();
    }

    public function test_landing_links_to_public_gallery(): void
    {
        $this->get('/')->assertOk()->assertSee('/explorar', false);
    }

    public function test_gallery_has_useful_empty_state_and_paginates_public_videos(): void
    {
        $this->get('/explorar')->assertOk()->assertSee('Aún no hay videos públicos');

        foreach (range(1, 13) as $index) {
            $this->video(['is_public' => true, 'title' => 'Video '.$index]);
        }

        $this->get('/explorar')->assertOk()->assertSee('Video 13')->assertDontSee('Video 1</h3>', false);
        $this->get('/explorar?page=2')->assertOk()->assertSee('Video 1');
    }

    public function test_signed_in_user_can_find_explore_and_publish_option(): void
    {
        $video = $this->video();

        $this->actingAs($video->user)
            ->get('/admin')
            ->assertOk()
            ->assertSee('Explorar videos');

        $this->get('/admin/videos/'.$video->id.'/edit')
            ->assertOk()
            ->assertSee('Mostrar en Explorar');
    }

    public function test_guest_login_prompt_returns_to_public_video_after_authentication(): void
    {
        $video = $this->video(['is_public' => true]);

        $this->get('/explorar/'.$video->id)
            ->assertOk()
            ->assertSee('Inicia sesión')
            ->assertSee('/explorar/'.$video->id.'/participar', false);

        $this->get('/explorar/'.$video->id.'/participar')
            ->assertRedirect(route('filament.admin.auth.login'))
            ->assertSessionHas('url.intended', route('public-videos.show', $video));
    }

    public function test_owner_can_publish_and_unpublish_an_existing_video_from_panel(): void
    {
        $video = $this->video();
        $this->actingAs($video->user);

        $this->mock(VideoMetadata::class, function ($mock): void {
            $mock->shouldReceive('durationInSeconds')->andReturn(75.0);
        });

        Livewire::test(EditVideo::class, ['record' => $video->id])
            ->fillForm(['is_public' => true])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertTrue($video->fresh()->is_public);
        $this->get('/explorar/'.$video->id)->assertOk();

        Livewire::test(EditVideo::class, ['record' => $video->id])
            ->fillForm(['is_public' => false])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertFalse($video->fresh()->is_public);
        $this->get('/explorar/'.$video->id)->assertNotFound();
    }

    public function test_owner_sees_publication_status_in_video_list(): void
    {
        $video = $this->video();

        $this->actingAs($video->user)->get('/admin/videos')->assertOk()->assertSee('Privado');

        $video->update(['is_public' => true]);

        $this->get('/admin/videos')->assertOk()->assertSee('Público');
    }

    private function video(array $attributes = []): Video
    {
        Storage::fake('local');
        Storage::disk('local')->put('videos/sample.mp4', 'sample');

        return Video::create(array_merge([
            'user_id' => User::factory()->create()->id,
            'title' => 'Video privado',
            'location' => 'Cusco',
            'description' => 'Un viaje.',
            'path' => 'videos/sample.mp4',
            'duration_seconds' => 75,
            'mime_type' => 'video/mp4',
            'size_bytes' => 6,
        ], $attributes));
    }
}
