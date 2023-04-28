<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DomainController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\PhraseController;

/*
|-----------------  ---------------------------------------------------------
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

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

//Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');

Route::controller(ParticipantController::class)->middleware('auth:sanctum')->prefix('participants')->group( function() {
    Route::get('by-id/{id}' , 'getById');
    Route::get('by-email/{id}' , 'getByEmail');
});

Route::controller(DomainController::class)->middleware('auth:sanctum')->prefix('domains')->group(function() {
    Route::get('full-tree/{id}' , 'fullTree');
    Route::get('/{domain}' , 'show');
});


Route::middleware('auth:sanctum')->group(function() {
Route::get('levels/{id}', [LevelController::class , 'show']);
Route::get('phrases/{id}', [PhraseController::class , 'show']);   
});