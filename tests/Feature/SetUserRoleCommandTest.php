<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetUserRoleCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_promotes_a_user_to_admin_by_email(): void
    {
        $user = User::factory()->create(['email' => 'juan@turiplay.com']);

        $this->artisan('user:role', ['email' => 'juan@turiplay.com'])
            ->assertSuccessful();

        $this->assertSame(UserRole::Admin, $user->fresh()->role);
    }

    public function test_it_assigns_the_user_role_explicitly(): void
    {
        $admin = User::factory()->admin()->create(['email' => 'jefa@turiplay.com']);

        $this->artisan('user:role', ['email' => 'jefa@turiplay.com', 'role' => 'user'])
            ->assertSuccessful();

        $this->assertSame(UserRole::User, $admin->fresh()->role);
    }

    public function test_it_fails_when_the_email_does_not_exist(): void
    {
        $this->artisan('user:role', ['email' => 'nadie@turiplay.com'])
            ->assertFailed();
    }

    public function test_it_fails_with_an_invalid_role(): void
    {
        $user = User::factory()->create(['email' => 'ana@turiplay.com']);

        $this->artisan('user:role', ['email' => 'ana@turiplay.com', 'role' => 'superadmin'])
            ->assertFailed();

        $this->assertSame(UserRole::User, $user->fresh()->role);
    }
}
