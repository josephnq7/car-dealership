<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ManufacturerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//TODO: need to secure those by implement authentication (sanctum???)
Route::apiResource('car', CarController::class);
Route::apiResource('customer', CustomerController::class);
Route::apiResource('manufacturer', ManufacturerController::class);
Route::get('search-car', [CarController::class, 'search']);



