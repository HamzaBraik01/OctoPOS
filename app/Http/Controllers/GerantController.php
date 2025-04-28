<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class GerantController extends Controller
{
    public function index(Request $request)
    {
         $restaurants = Restaurant::all();
         return view('gerants.dashboard', compact('restaurants'));
    }
}
