<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use Illuminate\Http\Request;
//use App\Http\Requests\SeanceRequest;

class SeanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $seance = new Seance();
        $seance->time_begin = $request->start_time;
        $seance->film_id = $request->film;
        $seance->hall_id = $request->hall;
        $seance->types_of_chairs = $request->types_of_chairs;
        $seance->price_of_chair = $request->price_of_chair;
        $seance->save();

        return redirect()->route('home.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        $seance = Seance::find($id);
        $chairs = session('selected_chairs');
        $cost = session('cost');
        $hall = session('hall');
        $film = session('film');

        if (!isset($chairs, $cost, $hall, $film)) {
            return redirect()->route('main.index');
        }

        return view('payment',
            ['chairs' => $chairs,
             'cost' => $cost,
             'hall' => $hall,
             'film' => $film,
             'seance' => $seance]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seance $seance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seance $seance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $seance = Seance::find($id);

        if ($seance) {
            $seance->delete();
        }

        return redirect()->route('home.index');
    }
}
