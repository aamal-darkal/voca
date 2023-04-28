<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;
    function phrases(){
        return $this->belongsToMany(Phrase::class);
    }
    function wordType() {
        return $this->belongsTo(WordType::class);
    }
}
