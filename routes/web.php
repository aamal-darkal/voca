<?php

use App\Http\Controllers\Dashboard\DomainController;
use App\Http\Controllers\Dashboard\LanguageController;
use App\Http\Controllers\Dashboard\LevelController;
use App\Http\Controllers\Dashboard\ParticipantController;
use App\Http\Controllers\Dashboard\PhraseController;
use App\Http\Controllers\Dashboard\WordController;
use App\Http\Controllers\HomeController;
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

Auth::routes(['register' => false]);


Route::resource('languages' , LanguageController::class );
Route::get('participants' , [ParticipantController::class,'index'])->name('participants.index');
Route::resource('domains' , DomainController::class );
Route::resource('levels' , LevelController::class );    
Route::resource('phrases' , PhraseController::class );
Route::controller(HomeController::class )->group(function(){
    Route::get('/',  'index')->name('home');
    Route::get('/profile',  'editProfile')->name('home.editProfile');
    Route::post('/profile',  'saveProfile')->name('home.saveProfile');
});
Route::controller(WordController::class )->prefix('words')->group(function(){
    Route::get('edit' , 'edit')->name('words.edit');
    Route::post('save' , 'save')->name('words.save');
});

Route::get('test' , function() {
    
    return session()->get('phrase');
});

