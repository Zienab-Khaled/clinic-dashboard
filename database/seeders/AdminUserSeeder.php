<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Default credentials for مدير النظام (change after first login).
     */
    private const ADMIN_EMAIL = 'admin@hospital.sa';
    private const ADMIN_PASSWORD = 'Admin@123';

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => self::ADMIN_EMAIL],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make(self::ADMIN_PASSWORD),
                'email_verified_at' => now(),
            ]
        );
    }
}
