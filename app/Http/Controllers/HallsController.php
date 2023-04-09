<?php

namespace App\Http\Controllers;

use App\Models\Halls;
use Illuminate\Http\Request;

class HallsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $halls = Halls::all();
        return view('home', ['halls' => $halls]);
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
        $halls = new Halls();
        $halls->title = $request->title;
        $halls->is_sell_ticket = false;
        $halls->save();

        return redirect()->route('halls.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Halls $halls)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Halls $halls)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Halls $halls)
    {
        function makeUpdate($typerequest, $halls, $type)
        {
            $values = explode('-', $typerequest);
            foreach ($values as $value) {
                $idArr = explode('=', $value);
                $id = $idArr[0];
                $str = $idArr[1];
                $hall = $halls->find($id);
                $hall->$type = $str;
                $hall->update();
            }
        }

        if ($request->types_of_chairs) {
            makeUpdate($request->types_of_chairs, $halls, 'types_of_chairs');
        }

        if ($request->price_of_chair) {
            makeUpdate($request->price_of_chair, $halls, 'price_of_chair');
        }

        return redirect()->route('halls.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hall = Halls::find($id);
        if ($hall) {
            $hall->delete();
        }

        return redirect()->route('halls.index');
    }
}