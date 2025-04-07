<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class vUsersManageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('email', 'like', "%{$search}%")
                    ->orWhereHas('roles', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            })
            ->get();

        return view('users.manage.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.manage.show', compact('user'));
    }

    public function create()
    {
        return view('users.manage.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.manage.index')->with('success', 'Usuari creat correctament.');
    }

    public function edit(User $user)
    {
        return view('users.manage.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('users.manage.index')->with('success', 'Usuari actualitzat correctament.');
    }

    public function delete(User $user)
    {
        return view('users.manage.delete', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.manage.index')->with('success', 'Usuari eliminat correctament.');
    }
}
