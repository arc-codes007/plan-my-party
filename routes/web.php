<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('landing');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin-dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin_dashboard');
Route::get('/venue-form/{venue_id?}', [App\Http\Controllers\VenueController::class, 'venue_form'])->name('venue_form');
Route::get('/venue-list', [App\Http\Controllers\VenueController::class, 'venue_list'])->name('venue_list');
Route::get('/package-form/{package_id?}', [App\Http\Controllers\PackageController::class, 'package_form'])->name('package_form');
Route::get('/package-list', [App\Http\Controllers\PackageController::class, 'package_list'])->name('package_list');
Route::get('/reco_form', [App\Http\Controllers\FormController::class, 'reco_form'])->name('reco_form');



Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('public/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});