<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PanelDesignTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_keeps_metrics_and_upload_access(): void
    {
        Livewire::withoutLazyLoading();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get('/admin')
            ->assertOk()
            ->assertSee('Resumen de la plataforma')
            ->assertSee('Subir video')
            ->assertSee('Estadísticas por usuario')
            ->assertSee('tp-user-metrics', false)
            ->assertSee('turiplay-panel.css', false)
            ->assertSee('favicon.svg', false);
    }

    public function test_user_dashboard_does_not_expose_admin_metrics_or_users_navigation(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin')
            ->assertOk()
            ->assertSee('Tu espacio de viajes')
            ->assertSee('Mis videos')
            ->assertSee('Subir video')
            ->assertDontSee('Estadísticas por usuario')
            ->assertDontSee('href="'.url('/admin/users').'"', false);

        $this->actingAs($user)->get('/admin/users')->assertForbidden();
    }

    public function test_admin_resources_and_forms_render_with_the_panel_theme(): void
    {
        $admin = User::factory()->admin()->create();
        $video = Video::create([
            'user_id' => $admin->id,
            'title' => 'Video de prueba aislada',
            'location' => 'Cusco',
            'path' => 'qa/panel-test.mp4',
            'duration_seconds' => 60,
            'size_bytes' => 1024,
            'mime_type' => 'video/mp4',
        ]);
        $this->actingAs($admin);

        foreach (['/admin/videos', '/admin/videos/create', '/admin/users', '/admin/users/create',
            '/admin/users/'.$admin->id, '/admin/users/'.$admin->id.'/edit',
            '/admin/videos/'.$video->id, '/admin/videos/'.$video->id.'/edit'] as $url) {
            $this->get($url)->assertOk()->assertSee('turiplay-panel.css', false);
        }
    }
}
