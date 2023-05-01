<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description' , 'domain_id' , 'order' ];

    function domain() {
        return $this->belongsTo(Domain::class);
    }

    function phrases() {
        return $this->hasMany(Phrase::class);
    }

    function langAlts() {
        return $this->belongsToMany(Language::class);
    }
    function words() {
        return $this->belongsToMany(Word::class);
    }
    function participants() {
        return $this->belongsToMany(Participant::class)->withPivot('status');
    }
}
