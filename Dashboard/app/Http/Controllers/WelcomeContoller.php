<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeContoller extends Controller
{
    //

    public function welcome()
    {
       return view('mydoc',['username'=> 'Ragahad']);
    }
}
