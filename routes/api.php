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


Route::get('/stationary', [StationaryController::class, 'getStationary']);
Route::get('/sports', [SportsController::class, 'getSports']);
Route::get('/events', [EventsController::class, 'getEvents']);
Route::get('/holidays', [HolidayController::class, 'getHolidays']);
Route::get('/furniture', [FurnitureController::class, 'getFurniture']);
Route::get('/libraries', [LibraryController::class, 'getLibraries']);
Route::get('/labs', [LabController::class, 'getLabs']);
Route::get('/computer-labs', [ComputerLabController::class, 'getComputerLabs']);

