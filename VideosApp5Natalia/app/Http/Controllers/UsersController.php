<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->get();

        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with('videos')->findOrFail($id);
        return view('users.show', compact('user'));
    }
}
