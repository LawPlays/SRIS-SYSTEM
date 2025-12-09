<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create main admin account
        User::updateOrCreate(
            ['email' => 'admin@sris.edu'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'approved',
            ]
        );

        // Keep existing admin account
        User::updateOrCreate(
            ['email' => 'laurencemalanum56@gmail.com'],
            [
                'name' => 'Laurence Malanum',
                'password' => Hash::make('Aura.Law56'),
                'role' => 'admin',
                'status' => 'approved',
            ]
        );
    }
}
