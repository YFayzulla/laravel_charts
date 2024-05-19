<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class Website extends Controller
{
    public function index(){
        $data = Student::first();
        return view("index" ,compact("data"));
    }
}
