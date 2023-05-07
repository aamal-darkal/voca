<?php

use App\Http\Controllers\Dashboard\DomainController;
use App\Http\Controllers\Dashboard\LanguageController;
use App\Http\Controllers\Dashboard\LevelController;
use App\Http\Controllers\Dashboard\ParticipantController;
use App\Http\Controllers\Dashboard\PhraseController;
use App\Models\Domain;
use App\Models\Level;
use App\Models\Participant;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('languages' , LanguageController::class );
Route::get('participants' , [ParticipantController::class,'index'])->name('participants.index');
Route::resource('domains' , DomainController::class );
Route::resource('levels' , LevelController::class );    
Route::resource('phrases' , PhraseController::class );

Route::get('test' , function() {
    return Participant::with('domains')->with('levels')->get();
});

