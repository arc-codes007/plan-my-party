<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->post('/add-update-venue-form', [App\Http\Controllers\VenueController::class, 'add_update_venue_form'])->name('add_update_venue');
Route::middleware('auth:api')->get('/fetch-venue-list', [App\Http\Controllers\VenueController::class, 'fetch_venue_list'])->name('fetch_venue_list');
Route::middleware('auth:api')->get('/fetch-venue-details', [App\Http\Controllers\VenueController::class, 'fetch_venue_details'])->name('fetch_venue_details');

