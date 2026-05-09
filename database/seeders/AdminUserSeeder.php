<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the default admin account.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@movieweb.local'],
            [
                'name' => 'MovieWeb Admin',
                'password' => Hash::make('Admin@123456'),
                'role' => 'admin',
                'status' => 'active',
            ],
        );
    }
}

