<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         \App\Models\User::create([
            'name' => 'Dr_moein',
            'email' => 'admin@site.com',
            'password' => Hash::make('password123'), // رمز عبور ادمین
        ]);
    }
}
