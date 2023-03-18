<?php

use App\Http\Controllers\PostController;
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
Route::get('/post', [PostController::class, 'getListPost']);
Route::post('/post', [PostController::class, 'addPost']);
Route::put('/post/{post_id}', [PostController::class, 'editPost']);
Route::delete('/post/{post_id}', [PostController::class, 'deletePost']);
