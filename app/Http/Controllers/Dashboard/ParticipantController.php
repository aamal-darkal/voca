<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dialect;
use App\Models\Language;
use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $language = $request->language;        

        $participants = Participant::when($language , function($q) use($language)  {
            return $q->wherehas('dialect', function($q1) use($language){
                return $q1->where('language_id' , $language);
            });
        })->paginate(8);
        $languages = Language::get();
        return view('dashboard.participants.index', compact('participants', 'languages'))->with('selectedlang', $language );
    }

    
}
