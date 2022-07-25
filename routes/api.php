<?php

use App\Http\Controllers\ApiController;
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


Route::get('/all-ebook', [ApiController::class, 'allEbook']);
Route::get('/ebook/{id}', [ApiController::class, 'singleEbook']);

Route::get('/all-bookmark', [ApiController::class, 'allBookmark']);

Route::post('/bookmark', [ApiController::class, 'bookmark']);

Route::post('/recent-ebook', [ApiController::class, 'recentEbook']);


Route::post('/add-ebook', [ApiController::class, 'create']);

Route::get('/category', [ApiController::class, 'category']);

Route::get('/category-wise-ebook', [ApiController::class, 'categoryWiseEbook']);
