<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
<<<<<<< HEAD
use App\Models\students;
=======
>>>>>>> act2

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

<<<<<<< HEAD
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

=======
>>>>>>> act2
            if ($user->role === 'admin') {
                return redirect('/admin');
            }



<<<<<<< HEAD
            return redirect()->route('dashboard')->with('success', 'Successfully logged in.');
=======
            return redirect()->route('dashboard');
>>>>>>> act2
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
