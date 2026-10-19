<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('user:role {email : Correo del usuario} {role=admin : admin o user}')]
#[Description('Asigna un rol (por defecto admin) a un usuario por su correo.')]
class SetUserRoleCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');
        $role = UserRole::tryFrom(strtolower($this->argument('role')));

        if (! $role) {
            $this->error("Rol inválido. Usa 'admin' o 'user'.");

            return self::FAILURE;
        }

        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            $this->error("No existe un usuario con el correo {$email}.");

            return self::FAILURE;
        }

        if ($user->role === $role) {
            $this->info("El usuario {$email} ya tiene el rol {$role->value}.");

            return self::SUCCESS;
        }

        $user->role = $role;
        $user->save();

        $this->info("Rol {$role->label()} asignado a {$email}.");

        return self::SUCCESS;
    }
}
