<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ServiceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            ClinicSeeder::class,
            ServiceSeeder::class,
            DepartmentSeeder::class,
        ]);
    }
}
