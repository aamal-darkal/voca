<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordType extends Model
{
    use HasFactory;
    public $timestamps = false;
    function language() {
        return $this->belongsTo(Language::class);
    }
}
