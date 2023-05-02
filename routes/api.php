<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DomainController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\PhraseController;
use App\Models\Domain;
use App\Models\Level;

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



Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ParticipantController::class)->prefix('participants')->group(function () {
        Route::get('/{participant}', 'show');

        Route::get('/stages/{participant}', 'stages');
        Route::post('/', 'store');
        Route::patch('/{participant}', 'update');
    });
    
    Route::get('participant-email', [ParticipantController::class, 'getByEmail']);

    Route::controller(DomainController::class)->prefix('domains')->group( function() {
        Route::get('/', 'index');
        Route::get('/{domain}',  'show');
        Route::get('/fulltree/{domain}', 'fulltree');
    });
    
    Route::get('levels/{id}', [LevelController::class, 'show']);
    Route::get('phrases/{id}', [PhraseController::class, 'show']);
});