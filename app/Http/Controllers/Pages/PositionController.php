<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class PositionController extends Controller
{
    public function index()
    {
        return view('positions');
    }

}
