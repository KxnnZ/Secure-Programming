<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\MovieAdminController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\Admin\ShowtimeController;

Route::get('/', fn () => redirect('/login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'));
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth')->get('/home', fn () => redirect('/dashboard'));

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('movies', MovieAdminController::class)->except(['show']);
}); 

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');

Route::get('/', fn() => redirect()->route('movies.index'));

Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('movies', \App\Http\Controllers\Admin\MovieAdminController::class)->except(['show']);
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

Route::get('/showtimes/{showtime}/seats', [SeatController::class,'index'])->name('seats.index');
Route::get('/api/showtimes/{showtime}/seats', [SeatController::class,'availability'])->name('seats.availability');
Route::post('/showtimes/{showtime}/book', [SeatController::class,'book'])->name('seats.book');


Route::middleware(['auth']) 
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/showtimes', [ShowtimeController::class,'index'])->name('showtimes.index');
        Route::post('/showtimes', [ShowtimeController::class,'store'])->name('showtimes.store');
        Route::delete('/showtimes/{showtime}', [ShowtimeController::class,'destroy'])->name('showtimes.destroy');
    });


Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');