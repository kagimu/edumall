<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StationaryController;
use App\Http\Controllers\SportsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\FurnitureController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\ComputerLabController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;



Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
     Route::get('/dashboard/orders', [OrderController::class, 'dashboard'])->name('dashboard.orders');
    Route::post('/orders/{order}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('orders.confirmPayment');
    Route::get('/stationaries', [StationaryController::class, 'index'])->name('index.stationaries');
    Route::get('/stationaries/create', [StationaryController::class, 'create'])->name('create.stationaries');
    Route::post('/stationaries/store', [StationaryController::class, 'store'])->name('store.stationaries');
    Route::get('/stationaries/{stationary}/edit', [StationaryController::class, 'edit'])->name('edit.stationaries');
    Route::put('/stationaries/{stationary}', [StationaryController::class, 'update'])->name('update.stationaries');
    Route::delete('/stationaries/{stationary}', [StationaryController::class, 'destroy'])->name('destroy.stationaries');

    Route::get('/sports', [SportsController::class, 'index'])->name('index.sports');
    Route::get('/sports/create', [SportsController::class, 'create'])->name('create.sports');
    Route::post('/sports/store', [SportsController::class, 'store'])->name('store.sports');
    Route::get('/sports/{sports}/edit', [SportsController::class, 'edit'])->name('edit.sports');
    Route::put('/sports/{sports}', [SportsController::class, 'update'])->name('update.sports');
    Route::delete('/sports/{sports}', [SportsController::class, 'destroy'])->name('destroy.sports');

    Route::get('/events', [EventsController::class, 'index'])->name('index.events');
    Route::get('/events/create', [EventsController::class, 'create'])->name('create.events');
    Route::post('/events/store', [EventsController::class, 'store'])->name('store.events');
    Route::get('/events/{events}/edit', [EventsController::class, 'edit'])->name('edit.events');
    Route::put('/events/{events}', [EventsController::class, 'update'])->name('update.events');
    Route::delete('/events/{events}', [EventsController::class, 'destroy'])->name('destroy.events');

    Route::get('/holidays', [HolidayController::class, 'index'])->name('index.holidays');
    Route::get('/holidays/create', [HolidayController::class, 'create'])->name('create.holidays');
    Route::post('/holidays/store', [HolidayController::class, 'store'])->name('store.holidays');
    Route::get('/holidays/{holiday}/edit', [HolidayController::class, 'edit'])->name('edit.holidays');
    Route::put('/holidays/{holiday}', [HolidayController::class, 'update'])->name('update.holidays');
    Route::delete('/holidays/{holiday}', [HolidayController::class, 'destroy'])->name('destroy.holidays');

    Route::get('/furniture', [FurnitureController::class, 'index'])->name('index.furniture');
    Route::get('/furniture/create', [FurnitureController::class, 'create'])->name('create.furniture');
    Route::post('/furniture/store', [FurnitureController::class, 'store'])->name('store.furniture');
    Route::get('/furniture/{furniture}/edit', [FurnitureController::class, 'edit'])->name('edit.furniture');
    Route::put('/furniture/{furniture}', [FurnitureController::class, 'update'])->name('update.furniture');
    Route::delete('/furniture/{furniture}', [FurnitureController::class, 'destroy'])->name('destroy.furniture');

    Route::get('/libraries', [LibraryController::class, 'index'])->name('index.libraries');
    Route::get('/libraries/create', [LibraryController::class, 'create'])->name('create.libraries');
    Route::post('/libraries/store', [LibraryController::class, 'store'])->name('store.libraries');
    Route::get('/libraries/{library}/edit', [LibraryController::class, 'edit'])->name('edit.libraries');
    Route::put('/libraries/{library}', [LibraryController::class, 'update'])->name('update.libraries');
    Route::delete('/libraries/{library}', [LibraryController::class, 'destroy'])->name('destroy.libraries');

    Route::get('/Labs', [LabController::class, 'index'])->name('index.labs');
    Route::get('/Labs/create', [LabController::class, 'create'])->name('create.labs');
    Route::post('/Labs/store', [LabController::class, 'store'])->name('store.labs');
    Route::get('/Labs/{lab}/edit', [LabController::class, 'edit'])->name('edit.labs');
    Route::put('/Labs/{lab}', [LabController::class, 'update'])->name('update.labs');
    Route::delete('/Labs/{lab}', [LabController::class, 'destroy'])->name('destroy.labs');

    Route::get('/computerLabs', [ComputerLabController::class, 'index'])->name('index.computerLabs');
    Route::get('/computerLabs/create', [ComputerLabController::class, 'create'])->name('create.computerLabs');
    Route::post('/computerLabs/store', [ComputerLabController::class, 'store'])->name('store.computerLabs');
    Route::get('/computerLabs/{computerLab}/edit', [ComputerLabController::class, 'edit'])->name('edit.computerLabs');
    Route::put('/computerLabs/{computerLab}', [ComputerLabController::class, 'update'])->name('update.computerLabs');
    Route::delete('/computerLabs/{computerLab}', [ComputerLabController::class, 'destroy'])->name('destroy.computerLabs');


});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
