<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Testing\Fakes\Fake;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        for ($i = 0; $i < 10; $i++) {

            Student::create([
                "name"=> fake()->name,
                "number"=> fake()->name,
                "status"=> fake()->phoneNumber(),
                "age"=> fake()->numberBetween(0,50),
            ]);
        }
    }
}
