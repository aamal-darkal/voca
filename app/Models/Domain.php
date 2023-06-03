<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;
    public static $langkey ;

    protected $fillable = ['title', 'description' ,    'order','language_id' ];
    function levels() {
        return $this->hasMany(Level::class);
    }
    function phrases() {
        return $this->hasManyThrough(Phrase::class , Level::class);
    }   
    function language() {
        return $this->belongsTo(Language::class);
    }
    function langApps() {
        return $this->belongsToMany(Language::class)->where('key' , SELF::$langkey)->withPivot(['title' , 'description']);
    }
    function languages() {
        return $this->belongsToMany(Language::class)->withPivot(['title' , 'description']);
    }
    function participants() {   
        return $this->belongsToMany(Participant::class)->withPivot('status');
    }  
   
}
