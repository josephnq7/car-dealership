<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->insert([
            [
                'user_name' => 'manager',
                'email' => 'manager@gmail.com',
                'is_manager' => 1,
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('manager')
            ],
            [
                'user_name' => 'user',
                'email' => 'user@gmail.com',
                'is_manager' => 0,
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('user')
            ],
        ]);
    }
}
