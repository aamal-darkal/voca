<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    function domain() {
        return $this->belongsTo(Domain::class);
    }

    function phrase() {
        return $this->hasMany(Phrase::class);
    }

    function langAlts() {
        return $this->belongsToMany(Language::class);
    }
}
