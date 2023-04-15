<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Hall;
use Illuminate\Http\Request;

class HallController extends Controller
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
        $halls = new Hall();
        $validated = $request->validate(['title' => ['required', 'unique:halls','string', 'max:30']]);
        if ($validated) {
            $halls->title =$request->title;
            $halls->save();
        }
        return redirect()->route('home.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hall $halls)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hall $halls)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hall $halls): \Illuminate\Http\RedirectResponse
    {
        if ($request->types_of_chairs) {
            $validated = $request->validate(['types_of_chairs' => ['required', 'string', 'min:6']]);
            if ($validated) {
                $halls->makeUpdate($request->types_of_chairs, 'types_of_chairs');
            }
        } elseif ($request->price_of_chair) {
            $validated = $request->validate(['price_of_chair' => ['required', 'string', 'min:4']]);
            if ($validated) {
                $halls->makeUpdate($request->price_of_chair, 'price_of_chair');
            }
        } elseif ($request->is_sell_ticket) {
            $validated = $request->validate(['is_sell_ticket' => ['required', 'string']]);
            if ($validated) {
                $halls->makeUpdate($request->is_sell_ticket, 'is_sell_ticket');
            }
        }

        return redirect()->route('home.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $hall = Hall::find($id);
        if ($hall) {
            $hall->delete();
        }

        return redirect()->route('home.index');
    }
}
