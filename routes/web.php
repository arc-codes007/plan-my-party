<?php

use Illuminate\Support\Facades\Route;

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