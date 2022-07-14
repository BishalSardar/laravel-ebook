<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/home', [EbookController::class, 'store'])->name('home.store');
Route::get('edit/{id}', [EbookController::class, 'edit'])->name('edit');
Route::post('update/{id}', [EbookController::class, 'update'])->name('update');
Route::get('delete/{id}', [EbookController::class, 'delete'])->name('delete');
