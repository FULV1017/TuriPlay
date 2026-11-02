<?php

namespace Tests\Feature;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;

final class LandingTest extends TestCase
{
    #[Test]
    #[TestDox('guests see the landing page at the root url')]
    public function guestsSeeTheLandingPage(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('TuriPlay', false)
            ->assertSee('Explora el Perú en movimiento', false)
            ->assertSee(route('filament.admin.auth.register'), false)
            ->assertSee(route('filament.admin.auth.login'), false)
            ->assertSee('Explorar videos', false)
            ->assertSee(route('public-videos.index'), false);
    }

    #[Test]
    public function landingUsesBuiltAssetsWithoutTheDevelopmentServer(): void
    {
        app(\Illuminate\Foundation\Vite::class)->useHotFile(
            storage_path('framework/testing-landing-no-vite.hot')
        );

        $this->get('/')
            ->assertOk()
            ->assertSee('/build/assets/app-', false)
            ->assertSee('/build/assets/barlow-condensed-semibold-', false);
    }

    #[Test]
    #[TestDox('authenticated users are redirected to the filament panel')]
    public function authenticatedUsersAreRedirectedToThePanel(): void
    {
        $user = User::factory()->make(['id' => 1]);

        $this->actingAs($user)
            ->get('/')
            ->assertRedirect('/admin');
    }
}
