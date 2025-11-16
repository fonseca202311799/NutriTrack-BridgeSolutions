<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\students;


class RegisterController extends Controller
{
     public function __invoke(Request $request)
    {
         $userData = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $userData['password'] = bcrypt($userData['password']);

        $user = User::create($userData);

        Auth::login($user);

        // Ensure a linked student profile exists
        $existing = students::where('user_id', $user->id)->first();
        if (!$existing) {
            students::create([
                'user_id' => $user->id,
                'student_id' => 'STU-' . $user->id,
            ]);
        }

        return redirect()->route('dashboard');
    }
}
