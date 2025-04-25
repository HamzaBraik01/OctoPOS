<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;


class ServeurController extends Controller
{
    public function index(Request $request)
    {
        $restaurants = Restaurant::all();
        return view('serveurs.dashboard', compact('restaurants'));
    }
}
