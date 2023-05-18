<?php

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

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);



Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ParticipantController::class)->prefix('participants')->group(function () {
        Route::get('/{participant}', 'show');
        Route::get('/DomainsStatus/{participant}', 'DomainsStatus');
        Route::get('/LevelStatus/{participant}', 'LevelStatus');

        Route::post('/', 'store');
        Route::patch('/{participant}', 'update');

        Route::post( 'attachDomain/{participant}','attachDomain');
        Route::post( 'attachLevel/{participant}','attachLevel');
        Route::post( 'attachPhrase/{participant}','attachPhrase');
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