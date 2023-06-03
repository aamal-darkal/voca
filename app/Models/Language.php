<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    public $timestamps = false;
    protected $fillable = ['name' , 'key'];

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
    function levels() {
        return $this->hasManyThrough( Level::class , Domain::class);
    }
    function phrases() {
        return $this->hasOneDeep( Phrase::class , [Domain::class, Level::class]);
    }
}
