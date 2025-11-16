<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\students;

class LoginController extends Controller
{
     public function __invoke(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Ensure a linked student profile exists for non-admins
            if (!$user->role || $user->role === 'student' || $user->role === 'teacher') {
                $existing = students::where('user_id', $user->id)->first();
                if (!$existing) {
                    students::create([
                        'user_id' => $user->id,
                        'student_id' => 'STU-' . $user->id,
                    ]);
                }
            }

            if ($user->role === 'admin') {
                return redirect('/admin');
            }



            return redirect()->route('dashboard')->with('success', 'Successfully logged in.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
