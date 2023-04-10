<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Halls;
use App\Models\Seance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $halls = Halls::all();
        $films= Film::all();
        $seances = Seance::all();
        return view('home',
            ['halls' => $halls,
             'films' => $films,
             'seances' => $seances]);
    }
}
