<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
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
        $film = new Film();
        $validated = $request->validate([
            'title' => ['required', 'unique:films','string', 'max:60'],
            'duration' => ['required', 'integer', 'min:30', 'max:220']
        ]);
        if ($validated) {
            $film->title = $request->title;
            $film->duration = $request->duration;
            $film->save();
        }
        return redirect()->route('home.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Film $film)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $film = Film::find($id);
        if ($film) {
            $film->delete();
        }

        return redirect()->route('home.index');
    }
}
