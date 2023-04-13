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
    public function show($id)
    {
        $seance = Seance::find($id);
        $halls = Halls::all();
        $films= Film::all();
        return view('seance',
            ['seance' => $seance,
            'halls' => $halls,
            'films' => $films]);
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
    public function update(Request $request, $id)
    {
        $seance = Seance::find($id);
        $seance->types_of_chairs = $request->types_of_chairs;
        $seance->update();
        session_start();
        $_SESSION['selected_chairs'] = $request->selected_chairs;
        $_SESSION['cost'] = $request->cost;
        $_SESSION['hall'] = $request->hall;
        $_SESSION['film'] = $request->film;

        return redirect()->route('seance.show', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Main $main)
    {
        //
    }
}
