<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('auth.users');
    }

    public function create()
    {
        return view('auth.create');
    }

    public function edit($id)
    {
        return view('auth.users', compact('id'));
    }

    public function resetPassword()
    {
        return view('auth.reset-password');
    }
}

