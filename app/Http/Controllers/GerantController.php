<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GerantController extends Controller
{
    public function index(Request $request)
    {
         return view('gerants.dashboard');
    }
}
