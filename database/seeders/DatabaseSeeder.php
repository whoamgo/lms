<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@lms.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Create Trainer User
        User::create([
            'name' => 'Trainer User',
            'email' => 'trainer@lms.com',
            'password' => bcrypt('password'),
            'role' => 'trainer',
            'status' => 'active',
        ]);

        // Create Student User
        User::create([
            'name' => 'Student User',
            'email' => 'student@lms.com',
            'password' => bcrypt('password'),
            'role' => 'student',
            'status' => 'active',
        ]);
    }
}
