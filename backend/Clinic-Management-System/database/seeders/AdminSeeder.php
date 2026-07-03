<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::updateOrCreate(
            ['email' => 'admin@site.com'],
            [
                'name' => 'Dr',
                'last_name' => 'Moein',
                'email' => 'admin@site.com',
                'mobile' => '09123456789',
                'national_code' => '1234567890',
                'birth_date' => '1995-01-01',
                'gender' => 'male',
                'password' => 'password',
                'role' => 'admin',
            ]
        );
    }
}
