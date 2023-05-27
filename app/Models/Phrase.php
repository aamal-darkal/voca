<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phrase extends Model
{
    use HasFactory;
    protected $fillable = ['content' , 'translation' ,'word_count' , 'level_id'];
    function level() {
        return $this->belongsTo(Level::class);
    }
    function words(){
        return $this->belongsToMany(Word::class)->withPivot(['id', 'translation' , 'order']);
    }
    function participants() {
        return $this->belongsToMany(Participant::class)->withPivot(['status']);;
    }
}
