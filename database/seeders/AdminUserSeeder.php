<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the default administrator account.
     *
     * The account is created only when an admin with the configured
     * email does not already exist, so this seeder is safe to run
     * repeatedly. Configuration comes from the application environment.
     *
     * @throws RuntimeException when the configured password is empty or is
     *                          still the insecure default in production
     */
    public function run(): void
    {
        $name = (string) config('stockpilot.default_admin.name');
        $email = (string) config('stockpilot.default_admin.email');
        $password = (string) config('stockpilot.default_admin.password');

        $admin = User::query()
            ->where('email', $email)
            ->first();

        if ($admin !== null) {
            $this->command->info("Admin user '{$email}' already exists. Skipped.");

            return;
        }

        $this->assertUsablePassword($password);

        $admin = new User;
        $admin->forceFill([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'email_verified_at' => now(),
            'role' => UserRole::ADMIN,
            'status' => 'active',
        ])->save();

        $this->command->info("Admin user '{$email}' created successfully.");
    }

    /**
     * Refuse to create a default administrator with an empty or, in
     * production, a weak password.
     *
     * @throws RuntimeException
     */
    private function assertUsablePassword(string $password): void
    {
        if ($password === '') {
            throw new RuntimeException(
                'DEFAULT_ADMIN_PASSWORD must be set in the application environment before seeding the default administrator.'
            );
        }

        if (! app()->isProduction()) {
            return;
        }

        if ($password === 'password' || strlen($password) < 12) {
            throw new RuntimeException(
                'DEFAULT_ADMIN_PASSWORD must be a strong, unique value (at least 12 characters) in production.'
            );
        }
    }
}
