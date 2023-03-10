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
Route::get('/user-list', [App\Http\Controllers\UserController::class, 'user_list'])->name('user_list');

Route::get('/profile_admin_view/{id}', [App\Http\Controllers\ProfileController::class, 'profile_admin_view'])->name('profile_admin_view');
Route::get('/profile_view', [App\Http\Controllers\ProfileController::class, 'profile_view'])->name('profile_view');

Route::get('/edit_user_profile', [App\Http\Controllers\ProfileController::class, 'edit_user_profile'])->name('edit_user_profile');

Route::get('/reset_password', [App\Http\Controllers\ProfileController::class, 'reset_pass'])->name('reset_password');
Route::post('/update_password', [App\Http\Controllers\ProfileController::class, 'update_password'])->name('update_password');

Route::get('/venue-details/{venue_id?}', [App\Http\Controllers\VenueController::class, 'show_venue_details'])->name('venue_details');
// Party Routes
Route::get('/party/form', [App\Http\Controllers\PartyController::class, "party_form"])->name('main_party_form');
Route::get('/party/form/{party_id?}', [App\Http\Controllers\PartyController::class, "party_form"])->name('party_planning');

//template route
Route::get('/template-form/{template_id?}', [App\Http\Controllers\InviteTemplateController::class, 'template_form'])->name('template_form');
Route::get('/template-list', [App\Http\Controllers\InviteTemplateController::class, 'template_list'])->name('template_list');
