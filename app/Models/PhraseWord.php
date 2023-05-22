<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhraseWord extends Model
{
    use HasFactory;
    protected $table='phrase_word';

    function participants() {
        return $this->belongsToMany(Participant::class)->withPivot(['status']);
    }
}
