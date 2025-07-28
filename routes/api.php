<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\StationaryController;
use App\Http\Controllers\SportsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\FurnitureController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\Api\LabApiController;
use App\Http\Controllers\ComputerLabController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;


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

    Route::get('/orders/pending', [OrderController::class, 'checkPendingOrder']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('/checkout/confirm-pay-on-delivery', [OrderController::class, 'confirmPayOnDelivery']);
    Route::get('/orders', [OrderController::class, 'index']);


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


// CORS preflight
Route::options('labs', function() {
    return Response::make('OK', 200)
        ->header('Access-Control-Allow-Origin', 'https://edumall-uganda.netlify.app')
        ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
});

// Lab routes
Route::prefix('labs')->group(function () {
    Route::get('/', [LabApiController::class, 'index'])->middleware('cors');
    Route::middleware(['auth:sanctum', 'cors'])->group(function () {
        Route::post('/', [LabApiController::class, 'store']);
    });
});

Route::get('/computer-labs', [ComputerLabController::class, 'getComputerLab'])
    ->middleware('cors')
    ->name('api.computer_lab');

