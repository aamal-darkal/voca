<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;
    protected $fillable = ['content' , 'word_type_id' ];

    function phrases(){
        return $this->belongsToMany(Phrase::class)->withpivot(['translation' , 'order']);
    }
    function wordType() {
        return $this->belongsTo(WordType::class);
    }
}
