<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CourierController;

Route::get('/', function () {
    return view('auth.register');
})->name('register');


Route::get('/client/register', [ClientController::class, 'showRegistrationForm'])->name('client.register');
Route::post('/client/register', [ClientController::class, 'register'])->name('client.register');
Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard')->middleware('check.role:1');

Route::get('/courier/register', [CourierController::class, 'showRegistrationForm'])->name('courier.register');
Route::post('/courier/register', [CourierController::class, 'registerСourier'])->name('courier.register');
Route::get('/courier/dashboard', [CourierController::class, 'dashboard'])->name('courier.courier-dashboard')->middleware('check.role:2');

Auth::routes();
