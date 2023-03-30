<?php

namespace App\Http\Controllers;

use App\Models\IsSellTicket;
use Illuminate\Http\Request;

class IsSellTicketController extends Controller
{
    public function index()
    {
        $table = IsSellTicket::all();
        return view('main', [
            'isSellTicket' => $table,
        ]);
    }
}
