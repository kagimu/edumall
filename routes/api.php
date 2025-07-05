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
    Route::get('/cart/all', [CartController::class, 'allCarts']);
    Route::get('/cart', [CartController::class, 'view']);               // ✅ Fetch cart
    Route::post('/cart/add', [CartController::class, 'add']);           // ✅ Add to cart
    Route::put('/cart/{product_id}', [CartController::class, 'update']); // ✅ Update quantity
    Route::delete('/cart/remove/{product_id}', [CartController::class, 'remove']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/checkout', [OrderController::class, 'checkout']);
    Route::post('/pay', [OrderController::class, 'initiatePayment']);
    Route::post('/checkout/confirm-pay-on-delivery', [CheckoutController::class, 'confirmPayOnDelivery']);

});

Route::post('/flutterwave/webhook', [CheckoutController::class, 'handleWebhook']);
//cart and order routes
// API routes for various resources
Route::get('/stationary', [StationaryController::class, 'getStationary']);
Route::get('/sports', [SportsController::class, 'getSports']);
Route::get('/events', [EventsController::class, 'getEvents']);
Route::get('/holidays', [HolidayController::class, 'getHolidays']);
Route::get('/furniture', [FurnitureController::class, 'getFurniture']);
Route::get('/libraries', [LibraryController::class, 'getLibraries'])->name('api.libraries') ;
Route::get('/labs', [LabController::class, 'getLab'])->name('api.lab');
Route::get('/computer-labs', [ComputerLabController::class, 'getComputerLab'])->name('api.computer_lab');

Route::post('/labs', [LabController::class, 'store'])->name('api.lab');
