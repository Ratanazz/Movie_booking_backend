<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileTestController;
use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;




Route::apiResource('movies', MovieController::class);
Route::get('/profile-test', [ProfileTestController::class, 'index']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return response()->json(['message' => 'Welcome, Admin']);
    });
});

// Route::post('/book-seat', [BookingController::class, 'store']);
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/book-seat', [BookingController::class, 'store']);
    
// });
// Route::post('/book-seat', [BookingController::class, 'store']);
// Route::post('/book-seat', [BookingController::class, 'store'])->middleware('auth');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/book-seat', [BookingController::class, 'store']);
    Route::get('/shows/{show}/seats', [MovieController::class, 'getAvailableSeats']);
});

Route::get('/shows/{show}/book', [BookingController::class, 'show'])->name('bookings.show');
Route::get('/shows/{show}', [BookingController::class, 'show'])->name('bookings.show');
// Route::get('/shows/{id}/seats', [MovieController::class, 'getAvailableSeats']);