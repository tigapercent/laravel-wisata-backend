<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Index
    public function index(Request $request)
    {
        $users = DB::table('users')->when($request->keyword, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->keyword}%")
                ->orWhere('email', 'like', "%{$request->keyword}%")
                ->orWhere('phone', 'like', "%{$request->keyword}%");
        })->orderBy('id', 'desc')->paginate(10);
        return view('pages.users.index', compact('users'));
    }

    // Create
    public function create()
    {
        return view('pages.users.create');
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required',
            'role' => 'required',
        ]);

        User::create($request->all());
        return redirect()->route('users.index')->with('success', 'Akun berhasil dibuat!');
    }

    // Edit
    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

    // Update
    public function update(Request $request, User $user)
    {

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        // check phone
        if ($request->phone) {
            $user->update(['phone' => $request->phone]);
        }
        // check password
        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }
        return redirect()->route('users.index')->with('success', 'Akun berhasil diperbarui!');
    }

    // Delete
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Akun berhasil dihapus!');
    }
}
