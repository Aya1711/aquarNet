<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'ayat@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('ayat1234'),
                'role' => 'admin',
            ]
        );
    }
}