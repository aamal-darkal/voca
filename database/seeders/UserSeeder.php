<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'name' => 'voca-user',
            'email' => 'voca@test.com',
            'email_verified_at' => now(),
            'password' => hash::make("password"), // password
            'remember_token' => Str::random(10),
        ];
        User::create($user);
    }
}
