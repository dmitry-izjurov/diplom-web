<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Hall;
use App\Models\Main;
use App\Models\Seance;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $halls = Hall::all();
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
    public function show(int $id): \Illuminate\Contracts\View\View
    {
        $seance = Seance::find($id);
        $halls = Hall::all();
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
    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $seance = Seance::find($id);
        $validated = $request->validate(['types_of_chairs' => ['required', 'string', 'min:6']]);
        if ($validated) {
            $seance->types_of_chairs = $request->types_of_chairs;
            $seance->update();

            session([
                'selected_chairs' => $request->selected_chairs,
                'cost' => $request->cost,
                'hall' => $request->hall,
                'film' => $request->film]);

            return redirect()->route('seance.show', ['id' => $id]);
        } else {
            return redirect()->route('main.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Main $main)
    {
        //
    }
}
