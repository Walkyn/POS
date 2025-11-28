<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        return view('sales.index');
    }

    public function create()
    {
        return view('sales.create');
    }

    public function closeShift()
    {
        return view('sales.close-shift');
    }

    public function shiftHistory()
    {
        return view('sales.shift-history');
    }
}

