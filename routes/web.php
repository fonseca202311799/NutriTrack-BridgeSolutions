<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\HealthRecordsController;
use App\Http\Controllers\TipsController;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WaterIntakeController;
use App\Http\Controllers\ExerciseController;




Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('login', function() {
    return view('login');
})->name('login');

Route::post('login', LoginController::class)->middleware('throttle:5,1')->name('login.attempt');



Route::post('logout', function () {
    Auth::guard('web')->logout();

    Session::invalidate();
    Session::regenerateToken();

    return redirect('login');
})->name('logout');

Route::view('register', 'register')->name('register');
Route::post('register', RegisterController::class)->middleware('auth')->name('register.store');


Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class)->except(['show', 'edit', 'update']);
    Route::resource('health-records', HealthRecordsController::class);
    Route::resource('water-intakes', WaterIntakeController::class)->only(['index','store']);
    Route::resource('exercises', ExerciseController::class)->only(['index','store']);
    Route::resource('tips', TipsController::class);
    Route::resource('goals', GoalsController::class);
    Route::resource('students', StudentsController::class);


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
