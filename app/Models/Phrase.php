<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phrase extends Model
{
    use HasFactory;
    protected $fillable = ['content' , 'translation' ,'word_count' , 'level_id'];
    function level() {
        return $this->belongsTo(Domain::class);
    }
    function words(){
        return $this->belongsToMany(Word::class)->withPivot(['translation' , 'order']);
    }
}
