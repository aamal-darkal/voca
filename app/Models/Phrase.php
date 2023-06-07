<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Phrase extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = ['content' , 'translation' ,'word_count' , 'order','level_id'];
    function level() {
        return $this->belongsTo(Level::class);
    }
    function words(){
        return $this->belongsToMany(Word::class)->withPivot(['id', 'translation' , 'order']);
    }
    function participants() {
        return $this->belongsToMany(Participant::class)->withPivot(['status']);;
    }

    function domain() {
        return $this->belongsToThrough( Domain::class , Level::class);
    }       
    
    function language() {
        return $this->belongsToThrough(Language::class, [Domain::class , Level::class ]);
    }
}
