<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $attendances = [
            ['name' => 'Person1', 'date' => Carbon::parse('2024-12-30')],
            ['name' => 'Person1', 'date' => Carbon::parse('2024-12-02')],
            ['name' => 'Person1', 'date' => Carbon::parse('2024-12-03')],
            ['name' => 'Person2', 'date' => Carbon::parse('2024-12-01')],
            ['name' => 'Person2', 'date' => Carbon::parse('2024-12-04')],
            ['name' => 'Person3', 'date' => Carbon::parse('2024-12-05')],
            ['name' => 'Person3', 'date' => Carbon::parse('2024-12-30')],
            ['name' => 'Person4', 'date' => Carbon::parse('2024-12-07')],
            ['name' => 'Person4', 'date' => Carbon::parse('2024-12-08')],
            ['name' => 'Person5', 'date' => Carbon::parse('2024-12-09')],
            ['name' => 'Person5', 'date' => Carbon::parse('2024-12-10')],
        ];

        foreach ($attendances as $attendance) {
            Attendance::create($attendance);
        }
    }
}
