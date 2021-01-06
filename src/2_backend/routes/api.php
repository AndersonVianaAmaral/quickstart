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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('categories', App\Http\Controllers\CategoryController::class)->except(['create','edit']);
Route::resource('genders', App\Http\Controllers\GenderController::class)->except(['create','edit']);
Route::resource('castmembers', App\Http\Controllers\CastMemberController::class)->except(['create','edit']);
Route::resource('videos', App\Http\Controllers\VideosController::class)->except(['create','edit']);
