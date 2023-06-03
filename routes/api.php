<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DialectController;
use App\Http\Controllers\Api\DomainController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\PhraseController;
use App\Models\Domain;
use App\Models\Language;
use App\Models\Participant;
use App\Models\Phrase;
use App\Models\PhraseWord;
use Illuminate\Support\Arr;

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

    Route::get('dialects' , [DialectController::class , 'index'])->name('dialedcts.index');
    Route::get('languages/{language}' , [LanguageController::class , 'show'])->name('language.show');
    
    Route::controller(ParticipantController::class)->prefix('participants')->group(function () {
        Route::get('/{participant}', 'show');
        Route::get('/DomainsStatus/{participant}', 'domainsStatus');
        Route::get('/LevelStatus/{participant}', 'levelStatus');
        Route::get('/phraseStatus/{participant}', 'phraseStatus');

        Route::post('/', 'store');
        Route::patch('/{participant}', 'update');

        Route::post( 'attachDomain/{participant}','attachDomain');
        Route::post( 'attachLevel/{participant}','attachLevel');
        Route::post( 'attachPhrase/{participant}','attachPhrase');
        Route::post( 'attachWord/{participant}','attachWord');
        Route::post( 'handlePhraseTree/{participant}','handlePhraseTree');    
    });
    
    Route::get('participant-email', [ParticipantController::class, 'getByEmail']);

    
});

  
Route::get('test' , function() {
//    $phrases = Language::find(3)->phrases;
    $domain  = phrase:: find(1)->domain;
   return $domain->language_id;
});