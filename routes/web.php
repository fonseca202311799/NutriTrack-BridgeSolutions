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
    Route::resource('tips', TipsController::class);
    Route::resource('goals', GoalsController::class);
    Route::resource('students', StudentsController::class);
});
