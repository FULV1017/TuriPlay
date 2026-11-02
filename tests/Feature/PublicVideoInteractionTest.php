<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicVideoInteractionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_like_or_comment(): void
    {
        $video = $this->video();

        $this->post("/explorar/{$video->id}/like")->assertRedirect();
        $this->post("/explorar/{$video->id}/comentarios", ['body' => 'Qué bonito'])->assertRedirect();
        $this->assertDatabaseCount('video_likes', 0);
        $this->assertDatabaseCount('video_comments', 0);
    }

    public function test_like_toggles_without_duplicates(): void
    {
        $video = $this->video();
        $this->actingAs(User::factory()->create());

        $this->post("/explorar/{$video->id}/like")->assertRedirect();
        $this->assertDatabaseCount('video_likes', 1);
        $this->post("/explorar/{$video->id}/like")->assertRedirect();
        $this->assertDatabaseCount('video_likes', 0);
    }

    public function test_authenticated_comment_is_visible_to_everyone(): void
    {
        $video = $this->video();
        $this->actingAs(User::factory()->create())
            ->post("/explorar/{$video->id}/comentarios", ['body' => 'Hermoso destino'])
            ->assertRedirect();

        auth()->logout();
        $this->get("/explorar/{$video->id}")->assertOk()->assertSee('Hermoso destino');
    }

    public function test_private_videos_cannot_receive_public_interactions(): void
    {
        $video = $this->video(['is_public' => false]);
        $this->actingAs(User::factory()->create());

        $this->post("/explorar/{$video->id}/like")->assertNotFound();
        $this->post("/explorar/{$video->id}/comentarios", ['body' => 'Hola'])->assertNotFound();
    }

    public function test_comment_requires_nonempty_limited_text(): void
    {
        $video = $this->video();
        $this->actingAs(User::factory()->create());

        $this->post("/explorar/{$video->id}/comentarios", ['body' => ''])->assertSessionHasErrors('body');
        $this->post("/explorar/{$video->id}/comentarios", ['body' => str_repeat('a', 1001)])->assertSessionHasErrors('body');
        $this->assertDatabaseCount('video_comments', 0);
    }

    public function test_unpublishing_hides_comments_and_reactions_from_visitors(): void
    {
        $video = $this->video();
        $this->actingAs(User::factory()->create());
        $this->post("/explorar/{$video->id}/like")->assertRedirect();
        $this->post("/explorar/{$video->id}/comentarios", ['body' => 'Precioso'])->assertRedirect();

        $video->update(['is_public' => false]);

        $this->get("/explorar/{$video->id}")->assertNotFound();
        $this->post("/explorar/{$video->id}/like")->assertNotFound();
        $this->post("/explorar/{$video->id}/comentarios", ['body' => 'Otro'])->assertNotFound();
        $this->assertDatabaseCount('video_comments', 1);
    }

    public function test_comment_text_is_escaped_in_public_detail(): void
    {
        $video = $this->video();
        $this->actingAs(User::factory()->create());
        $this->post("/explorar/{$video->id}/comentarios", ['body' => '<script>alert(1)</script>']);

        auth()->logout();
        $this->get("/explorar/{$video->id}")
            ->assertOk()
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    private function video(array $attributes = []): Video
    {
        return Video::create(array_merge([
            'user_id' => User::factory()->create()->id,
            'title' => 'Machu Picchu',
            'location' => 'Cusco',
            'path' => 'videos/example.mp4',
            'duration_seconds' => 75,
            'mime_type' => 'video/mp4',
            'size_bytes' => 6,
            'is_public' => true,
        ], $attributes));
    }
}
