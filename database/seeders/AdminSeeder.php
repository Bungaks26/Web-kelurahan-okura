<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@okura.id'],
            [
                'name' => 'Admin Kelurahan',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'lurah@okura.id'],
            [
                'name' => 'Lurah Okura',
                'password' => Hash::make('password123'),
                'role' => 'lurah',
            ]
        );
    }
}