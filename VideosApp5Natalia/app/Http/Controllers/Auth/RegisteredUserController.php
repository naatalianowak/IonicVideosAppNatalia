<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Http\Controllers\Auth\RegisteredUserController as BaseController;

class RegisteredUserController
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $response = $this->create($request->all());
        return redirect()->route('login')->with('status', 'Registre completat amb èxit! Inicia sessió per continuar.');
    }
}
