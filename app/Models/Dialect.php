<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dialect extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['locale' , 'key' , 'language_id'];

    function language() {
        return $this->belongsTo(Language::class);
    }
    function participants() {
        return $this->hasMany(Participant::class);
    }

}
