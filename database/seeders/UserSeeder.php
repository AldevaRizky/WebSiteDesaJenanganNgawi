<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update an admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Desa',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        // Create some example users using the factory
        User::factory()->count(9)->create();
    }
}
