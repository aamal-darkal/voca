<?php

use App\Http\Controllers\Dashboard\DomainController;
use App\Http\Controllers\Dashboard\LanguageController;
use App\Http\Controllers\Dashboard\LevelController;
use App\Http\Controllers\Dashboard\ParticipantController;
use App\Http\Controllers\Dashboard\PhraseController;
use App\Http\Controllers\Dashboard\WordController;
use App\Http\Controllers\HomeController;
use App\Models\Domain;
use App\Models\Level;
use App\Models\Word;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*;
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

Route::middleware('auth')->group(function () {

    Route::get('participants', [ParticipantController::class, 'index'])->name('participants.index');

    Route::resource('languages', LanguageController::class)->except('show');
    Route::get('languages/delete/{language}', [LanguageController::class, 'delete'])->name('languages.delete');;

    Route::resource('domains', DomainController::class)->except('show');

    Route::get('domains/delete/{domain}', [DomainController::class, 'delete'])->name('domains.delete');;
    Route::get('domains/getDomains/{language}', [DomainController::class, 'getDomains'])->name('domains.getDomains');;

    Route::resource('levels', LevelController::class)->except('show');
    Route::get('levels/delete/{level}', [LevelController::class, 'delete'])->name('levels.delete');;
    Route::get('levels/gelLevels/{domain}/{language}', [LevelController::class, 'gelLevels'])->name('levels.gelLevels');;

    
    Route::resource('phrases', PhraseController::class)->except('show');
    Route::get('phrases/delete/{phrase}', [PhraseController::class, 'delete'])->name('phrases.delete');;
    Route::get('phrases/getPhrases/{level}/{domain}/{language}', [PhraseController::class, 'getPhrases'])->name('phrases.getPhrases');;

    Route::controller(HomeController::class)->group(function () {
        Route::get('/',  'index')->name('home');
        Route::get('/profile',  'editProfile')->name('home.editProfile');
        Route::post('/profile',  'saveProfile')->name('home.saveProfile');
    });
    Route::controller(WordController::class)->prefix('words')->group(function () {
        Route::get('edit', 'edit')->name('words.edit');
        Route::post('save', 'save')->name('words.save');
    });    
}); 

