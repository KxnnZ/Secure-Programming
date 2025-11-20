<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\MovieAdminController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\Admin\ShowtimeController;


Route::get('/', fn() => redirect()->route('movies.index'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'));
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
});

Route::middleware('auth')->get('/home', fn () => redirect()->route('movies.index'));


Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');

Route::middleware('auth')->group(function(){
    Route::get('/payments/{booking}/select', [\App\Http\Controllers\PaymentController::class, 'select'])->name('payments.select');
    Route::post('/payments/{booking}/process', [\App\Http\Controllers\PaymentController::class, 'process'])->name('payments.process');
});


Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('movies', \App\Http\Controllers\Admin\MovieAdminController::class)->except(['show']);
});

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