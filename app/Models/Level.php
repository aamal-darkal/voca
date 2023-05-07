<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    public static $langkey = 'ar';
    
    protected $fillable = ['title', 'description' , 'domain_id' , 'order' ];

    function domain() {
        return $this->belongsTo(Domain::class);
    }

    function phrases() {
        return $this->hasMany(Phrase::class);
    }

    function langAppsx() {
        return $this->belongsToMany(Language::class)->withPivot(['title' , 'description']);
    }
    function langApps() {
        return $this->belongsToMany(Language::class)->where('key' , SELF::$langkey)->withPivot(['title' , 'description']);
    }
    
    function words() {
        return $this->belongsToMany(Word::class);
    }
    function participants() {
        return $this->belongsToMany(Participant::class)->withPivot('status');
    }
    
    function locale( $langCode){
        if($langCode != config('app.main_lang')) {
            
            $this->title = Level::find($this->id)->langApps->where('key' , $langCode)[0]['pivot']['title'];  
            $this->description = Level::find($this->id)->langApps->where('key' , $langCode)[0]['pivot']['description'];  
        } 
        return $this;       
    }
}
