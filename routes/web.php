<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\HealthRecordsController;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WaterIntakeController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\SuggestionsController;
use App\Http\Controllers\TipsController;
// Removed duplicate TipsController import




Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('login', function() {
    return view('login');
})->middleware('guest')->name('login');

Route::post('login', LoginController::class)->middleware('throttle:5,1')->name('login.attempt');



Route::post('logout', function () {
    Auth::guard('web')->logout();

    Session::invalidate();
    Session::regenerateToken();

    return redirect('login');
})->name('logout');

Route::view('register', 'register')->middleware('guest')->name('register');
Route::post('register', RegisterController::class)->middleware('guest')->name('register.store');

// Public Terms & Conditions page
Route::view('/terms', 'terms')->name('terms');


Route::middleware(['auth', \App\Http\Middleware\FirstLoginAssessment::class])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class)->except(['show', 'edit', 'update']);
    Route::resource('health-records', HealthRecordsController::class);
    Route::resource('water-intakes', WaterIntakeController::class)->only(['index','store']);
    Route::resource('exercises', ExerciseController::class)->only(['index','store']);
    Route::resource('tips', TipsController::class);
    Route::resource('goals', GoalsController::class);
    Route::post('goals/{id}/restore', [GoalsController::class, 'restore'])->name('goals.restore');
    Route::resource('students', StudentsController::class);

    // Reports
    Route::get('reports/health', [ReportController::class, 'health'])->name('reports.health');
    Route::get('reports/health.csv', [ReportController::class, 'healthCsv'])->name('reports.health.csv');
    Route::get('reports/health.pdf', [ReportController::class, 'healthPdf'])->name('reports.health.pdf');

    // Admin API endpoints
    Route::get('admin/api/goals', [GoalsController::class, 'adminList'])->name('admin.api.goals');


    // Admin SPA entry (friendly redirect for non-admins instead of 403)
    Route::get('/admin', function () {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access the admin area.');
        }
        return view('admin-dashboard');
    })->name('admin.dashboard');

    // Backward compatibility: redirect old entry to new (no admin gate here; handled above)
    Route::redirect('/admin-dashboard', '/admin');

    // Catch all Vue routes for the admin (handled by Vue Router) with friendly redirect
    Route::get('/admin/{any}', function () {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access the admin area.');
        }
        return view('admin-dashboard');
    })->where('any', '.*');
});

// Assessment routes
Route::middleware(['auth'])->group(function(){
    Route::get('assessment', [AssessmentController::class, 'show'])->name('assessment.show');
    Route::post('assessment', [AssessmentController::class, 'submit'])->name('assessment.submit');
    // Regenerate AI Insights on demand
    Route::post('assessment/regenerate-insights', [AssessmentController::class, 'regenerateInsights'])->name('assessment.regenerate');
    // Apply AI suggestions (intake + goal)
    Route::post('ai/suggest/apply', [SuggestionsController::class, 'apply'])->name('ai.suggest.apply');
    // Generate AI-powered tips (rate limited to prevent spam)
    Route::post('ai/tips/generate', [TipsController::class, 'generate'])
        ->middleware('throttle:3,1')
        ->name('ai.tips.generate');
    // Replace today's tips (delete today's user-generated tips then regenerate)
    Route::post('ai/tips/replace', [TipsController::class, 'replaceToday'])
        ->middleware('throttle:3,1')
        ->name('ai.tips.replace');
});
