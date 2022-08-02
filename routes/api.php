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

Route::get('notebook', 'App\Http\Controllers\Controller@notebook');
Route::get('notebook/{id}', 'App\Http\Controllers\Controller@notebookById');

Route::post('notebook', 'App\Http\Controllers\Controller@notebookNew');
Route::post('notebook/{id}', 'App\Http\Controllers\Controller@notebookNewById');

Route::delete('notebook/{id}', 'App\Http\Controllers\Controller@notebookDelete');

Route::put('notebook/{id}', 'App\Http\Controllers\Controller@notebookEdit');
