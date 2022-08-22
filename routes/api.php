<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HeureSupController;

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

Route::post('register',[UserController::class, 'register']);
Route::post('login' ,[UserController::class, 'login']);
Route::get('users' ,[UserController::class, 'getUser']);
Route::get('user/{id}' ,[UserController::class, 'getUserById']);
Route::put('updateUser/{id}' ,[UserController::class, 'updateUser']);
Route::delete('deleteUser/{id}' ,[UserController::class, 'deleteUser']);

///////////////////////////////////////////////////
Route::get('heures/{id}', [HeureSupController::class, 'getHeure']);
Route::get('heure/{id}' ,[HeureSupController::class, 'getHeureById']);
Route::put('updateHeure/{id}' ,[HeureSupController::class, 'updateHeure']);
Route::delete('deleteHeure/{id}' ,[HeureSupController::class, 'deleteHeure']);
Route::post('addHeure',[HeureSupController::class, 'addHeure']);
