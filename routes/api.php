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
Route::get('/package/all-packages', [App\Http\Controllers\PackageController::class, 'fetch_all_packages'])->name('fetch_all_packages_data');
Route::get('/package/get-package_details', [App\Http\Controllers\PackageController::class, 'get_package_details'])->name('get_package_data');

Route::middleware('auth:api')->get('/fetch_venues', [App\Http\Controllers\FormController::class, 'fetch_venues'])->name('fetch_venues');
Route::middleware('auth:api')->post('/party_pref', [App\Http\Controllers\FormController::class, 'party_pref'])->name('party_pref');

Route::middleware('auth:api')->get('/admin/stats', [App\Http\Controllers\AdminController::class, 'fetch_admindash_stats'])->name('fetch_admin_dash_stats');

Route::middleware('auth:api')->get('/fetch-user-list', [App\Http\Controllers\UserController::class, 'fetch_user_list'])->name('fetch_user_list');


Route::middleware('auth:api')->get('/party/fetch-recommedations', [App\Http\Controllers\PartyController::class, 'fetch_party_recommedations'])->name('fetch_party_recommendations');