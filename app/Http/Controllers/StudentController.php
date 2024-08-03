<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function select()
    {

        return view('selet-with-multiple-options');

    }
}
