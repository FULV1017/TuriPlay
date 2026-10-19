<?php

namespace Tests\Feature;

use App\Filament\Resources\Videos\Pages\CreateVideo;
use App\Filament\Resources\Videos\Pages\ViewVideo;
use App\Models\User;
use App\Models\Video;
use App\Rules\MinVideoDuration;
use App\Services\VideoMetadata;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class VideoTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_stream_or_download_a_video(): void
    {
        $video = $this->makeVideo();

        $this->get(route('videos.stream', $video))->assertForbidden();
        $this->get(route('videos.download', $video))->assertForbidden();
    }

    public function test_authenticated_user_can_stream_a_video(): void
    {
        $video = $this->makeVideo();

        $this->actingAs($video->user)
            ->get(route('videos.stream', $video))
            ->assertOk();
    }

    public function test_authenticated_user_can_download_a_video(): void
    {
        $video = $this->makeVideo();

        $this->actingAs($video->user)
            ->get(route('videos.download', $video))
            ->assertOk()
            ->assertDownload('machu-picchu.mp4');
    }

    public function test_create_page_renders(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test(CreateVideo::class)
            ->assertOk();
    }

    public function test_video_view_page_renders_the_player(): void
    {
        $video = $this->makeVideo();

        $this->actingAs($video->user);

        Livewire::test(ViewVideo::class, [
            'record' => $video->getRouteKey(),
        ])
            ->assertOk()
            ->assertSee('videos/'.$video->id.'/stream', false);
    }

    public function test_min_video_duration_rule_rejects_short_videos(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('videos/short.mp4', 'fake-video-bytes');

        $this->mock(VideoMetadata::class, function ($mock): void {
            $mock->shouldReceive('durationInSeconds')->andReturn(30.0);
        });

        $failed = false;

        (new MinVideoDuration(60))->validate('path', 'videos/short.mp4', function () use (&$failed): void {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    public function test_min_video_duration_rule_accepts_long_videos(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('videos/long.mp4', 'fake-video-bytes');

        $this->mock(VideoMetadata::class, function ($mock): void {
            $mock->shouldReceive('durationInSeconds')->andReturn(90.0);
        });

        $failed = false;

        (new MinVideoDuration(60))->validate('path', 'videos/long.mp4', function () use (&$failed): void {
            $failed = true;
        });

        $this->assertFalse($failed);
    }

    private function makeVideo(): Video
    {
        Storage::fake('local');
        Storage::disk('local')->put('videos/sample.mp4', 'fake-video-bytes');

        $user = User::factory()->create();

        return Video::create([
            'user_id' => $user->id,
            'title' => 'Machu Picchu',
            'description' => 'Recorrido por la ciudadela inca.',
            'location' => 'Cusco',
            'duration_seconds' => 75,
            'mime_type' => 'video/mp4',
            'size_bytes' => 16,
            'path' => 'videos/sample.mp4',
        ]);
    }
}
