<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Auth\Pages\Register;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_renders_the_form(): void
    {
        Livewire::test(Register::class)
            ->assertOk()
            ->assertFormFieldExists('name')
            ->assertFormFieldExists('email')
            ->assertFormFieldExists('password')
            ->assertFormFieldExists('passwordConfirmation');
    }

    public function test_a_normal_user_can_register(): void
    {
        Livewire::test(Register::class)
            ->fillForm([
                'name' => 'Ana Turista',
                'email' => 'ana@turiplay.com',
                'password' => 'password123',
                'passwordConfirmation' => 'password123',
            ])
            ->call('register')
            ->assertHasNoFormErrors();

        $user = User::where('email', 'ana@turiplay.com')->firstOrFail();

        $this->assertSame(UserRole::User, $user->role);
        $this->assertNotSame('password123', $user->password);
        $this->assertTrue(Hash::check('password123', $user->password));
        $this->assertAuthenticatedAs($user);
    }

    public function test_registration_rejects_a_duplicate_email(): void
    {
        User::factory()->create(['email' => 'ana@turiplay.com']);

        Livewire::test(Register::class)
            ->fillForm([
                'name' => 'Otra Ana',
                'email' => 'ana@turiplay.com',
                'password' => 'password123',
                'passwordConfirmation' => 'password123',
            ])
            ->call('register')
            ->assertHasFormErrors(['email']);
    }

    public function test_a_registered_user_is_not_an_admin(): void
    {
        Livewire::test(Register::class)
            ->fillForm([
                'name' => 'Ana Turista',
                'email' => 'ana@turiplay.com',
                'password' => 'password123',
                'passwordConfirmation' => 'password123',
            ])
            ->call('register');

        $user = User::where('email', 'ana@turiplay.com')->firstOrFail();

        $this->actingAs($user);

        $this->assertFalse($user->isAdmin());
        $this->assertFalse(UserResource::canViewAny());
    }
}
