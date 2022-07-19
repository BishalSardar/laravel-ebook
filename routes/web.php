<?php

use App\Http\Controllers\EbookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});


Route::post('/cat', [EbookController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/home', [EbookController::class, 'store'])->name('home.store');
Route::get('edit/{id}', [EbookController::class, 'edit'])->name('edit');
Route::post('update/{id}', [EbookController::class, 'update'])->name('update');
Route::get('delete/{id}', [EbookController::class, 'delete'])->name('delete');
