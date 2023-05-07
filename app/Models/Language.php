<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name'];

    function dialects(){
        return $this->hasMany(Dialect::class);
    }

    function domains(){
        return $this->hasMany(Domain::class);
    }

    function participants() {
        return $this->hasManyThrough(Participant::class , Dialect::class);
    }

    function domainAlts() {
        return $this->belongsToMany(Domain::class);
    }

    function levelAlts() {
        return $this->belongsToMany(Level::class);
    }

    function wordTypes() {
        return $this->hasMany(WordType::class);
    }
}
