<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class Website extends Controller
{
    public function index(){

        $data = Student::all();

        $arr = '';

        foreach ($data as $key) {

            $arr.=  "['".$key->name."' , ".$key->age."],";

        }

        $newData['arr'] =rtrim($arr,',');


        return view("index", $newData );
    }
}







