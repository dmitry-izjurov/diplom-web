<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Halls;
use App\Models\Main;
use App\Models\Seance;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $halls = Halls::all();
        $films= Film::all();
        $seances = Seance::all();
        return view('main',
            ['halls' => $halls,
            'films' => $films,
            'seances' => $seances]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Main $main)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Main $main)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Main $main)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Main $main)
    {
        //
    }
}
