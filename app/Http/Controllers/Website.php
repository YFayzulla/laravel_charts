<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;

class Website extends Controller
{
    public function index()
    {

        $data = Student::all();

        $arr = '';

        foreach ($data as $key) {

            $arr .= "['" . $key->name . "' , " . $key->age . "],";

        }

        $newData['arr'] = rtrim($arr, ',');


        return view("index", $newData);
    }

    public function attandance()
    {
        $attendances = Attendance::all();

        $data = [];
        foreach ($attendances as $attendance) {
            // Use created_at or updated_at to determine the day
            $date = $attendance->date->format('d'); // or use updated_at if more appropriate
            $data[$attendance->name][$date] = '-'; // or other status
        }

        return view('attandance', ['data' => $data]);
    }

}








