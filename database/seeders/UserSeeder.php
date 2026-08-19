<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'admin@lotterydemo.test',
            ],
            [
                'name' => 'Administrator',
                'password' => Hash::make('Admin12345!'),
                'balance' => 0,
                'role' => 'admin',
                'status' => 'active',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'user@lotterydemo.test',
            ],
            [
                'name' => 'Demo User',
                'password' => Hash::make('User12345!'),
                'balance' => 10000,
                'role' => 'user',
                'status' => 'active',
            ]
        );
    }
}
