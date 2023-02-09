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
Route::middleware('auth:api')->post('/delete_image', [App\Http\Controllers\VenueController::class, 'delete_image'])->name('delete_image');

Route::middleware('auth:api')->post('/add-update-package-form', [App\Http\Controllers\PackageController::class, 'add_update_package_form'])->name('add_update_package');
Route::middleware('auth:api')->get('/fetch-package-list', [App\Http\Controllers\PackageController::class, 'fetch_package_list'])->name('fetch_package_list');
Route::middleware('auth:api')->get('/fetch-package-details', [App\Http\Controllers\PackageController::class, 'fetch_package_details'])->name('fetch_package_details');

Route::middleware('auth:api')->get('/fetch_venues', [App\Http\Controllers\FormController::class, 'fetch_venues'])->name('fetch_venues');
Route::middleware('auth:api')->post('/party_pref', [App\Http\Controllers\FormController::class, 'party_pref'])->name('party_pref');
