<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description' , 'language_id' ];
    function levels() {
        return $this->hasMany(Level::class);
    }
    function phrases() {
        return $this->hasManyThrough(Phrase::class , Level::class);
    }
    function language() {
        return $this->belongsTo(Language::class);
    }
    function langAlts() {
        return $this->belongsToMany(Language::class);
    }
    function participants() {
        return $this->belongsToMany(Participant::class)->withPivot('status');
    }
}
