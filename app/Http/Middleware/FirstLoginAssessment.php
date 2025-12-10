<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\students;
use App\Models\health_records;

class FirstLoginAssessment
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) return $next($request);

        if (($user->role ?? 'student') === 'admin') {
            return $next($request);
        }

        $student = students::where('user_id', $user->id)->first();
        $onAssessment = $request->routeIs('assessment.show') || $request->routeIs('assessment.submit');
        if (!$onAssessment) {
            if (!$student) {
                return redirect()->route('assessment.show');
            }
            $hasRecord = health_records::where('student_id', $student->id)->exists();
            if (!$hasRecord) {
                return redirect()->route('assessment.show');
            }
        }

        return $next($request);
    }
}
