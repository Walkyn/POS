<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return view('inventory.index');
    }

    public function movements()
    {
        return view('inventory.movements');
    }

    public function expired()
    {
        return view('inventory.expired');
    }

    public function outOfStock()
    {
        return view('inventory.out-of-stock');
    }
}

