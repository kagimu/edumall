<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StationaryController;
use App\Http\Controllers\SportsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\FurnitureController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\ComputerLabController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;


// Public login routes (no middleware)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

//cart and order routes
Route::post('/cart/add', [CartController::class, 'add']);
Route::post('/cart/remove', [CartController::class, 'remove']);
Route::get('/cart', [CartController::class, 'view']);
Route::post('/order', [OrderController::class, 'placeOrder']);

// API routes for various resources
Route::get('/stationary', [StationaryController::class, 'getStationary']);
Route::get('/sports', [SportsController::class, 'getSports']);
Route::get('/events', [EventsController::class, 'getEvents']);
Route::get('/holidays', [HolidayController::class, 'getHolidays']);
Route::get('/furniture', [FurnitureController::class, 'getFurniture']);
Route::get('/libraries', [LibraryController::class, 'getLibraries'])->name('api.libraries') ;
Route::get('/labs', [LabController::class, 'getLab'])->name('api.lab');
Route::get('/computer-labs', [ComputerLabController::class, 'getComputerLab'])->name('api.computer_lab');
