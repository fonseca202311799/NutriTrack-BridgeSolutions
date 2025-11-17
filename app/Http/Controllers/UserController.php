<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // FETCH ALL USERS (API)
    public function getUsers()
    {
        return response()->json(User::all());
    }

    // COUNT USERS (API)
    public function countUsers()
    {
        return response()->json(['total_users' => User::count()]);
    }

    // CREATE USER (API)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        // Auto-generate password from last name
        $nameParts = explode(' ', $validated['name']);
        $lastName = strtolower(end($nameParts));
        $generatedPassword = $lastName . "123";

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($generatedPassword),
            'role'     => 'student', // default
        ]);

        return response()->json([
            'message'             => 'User created successfully',
            'generated_password'  => $generatedPassword,
            'user'                => $user
        ], 201);
    }

    // UPDATE USER (API)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user'    => $user
        ]);
    }

    // DELETE USER (API)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
