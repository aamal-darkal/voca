<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' , 'email', 'avatar' ,'theme_app', 'is_admob' , 'lang_app' , 'dialect_id'];

    function dialect() {
        return $this->belongsTo(Dialect::class);
    }
    function domains() {
        return $this->belongsToMany(Domain::class)->withPivot('status');
    }
    function levels() {
        return $this->belongsToMany(Level::class)->withPivot('status');
    }
    function phrases() {
        return $this->belongsToMany(Phrase::class)->withPivot('status');
    }
    function words() {
        return $this->belongsToMany(PhraseWord::class)->withPivot('status') ;
    }
    function langApp(){
        return $this->belongsTo(Language::class , 'lang_app' );
    }
}
