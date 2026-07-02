<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ابتدا مطمئن می‌شویم که یک کاربر وجود دارد تا نوبت‌ها به او وصل شوند
        $user = User::first();

        if (!$user) {
            // اگر کاربر نبود، یکی می‌سازیم (فقط برای تست)
            $user = User::create([
                'name' => 'Test User',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // ایجاد چند نوبت نمونه با وضعیت‌های مختلف
        $appointments = [
            [
                'user_id' => $user->id,
                'appointment_date' => Carbon::now()->addDays(1)->setHour(10)->setMinute(0),
                'status' => 'pending',
            ],
            [
                'user_id' => $user->id,
                'appointment_date' => Carbon::now()->addDays(2)->setHour(14)->setMinute(30),
                'status' => 'confirmed',
            ],
            [
                'user_id' => $user->id,
                'appointment_date' => Carbon::now()->addDays(3)->setHour(16)->setMinute(0),
                'status' => 'cancelled',
            ],
        ];

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }

    }
}
