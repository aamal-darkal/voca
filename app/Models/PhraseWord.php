<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhraseWord extends Model
{
    use HasFactory;
    protected $table='phrase_word';
    public $timestamps = false;
    protected $fillable = ['phrase_id' , 'word_id', 'translation' , 'order'];

    function participants() {
        return $this->belongsToMany(Participant::class)->withPivot(['status']);
    }

    function word() {
        return $this->belongsTo(Word::class);
    }
}
