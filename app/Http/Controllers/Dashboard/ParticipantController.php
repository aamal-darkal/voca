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
        $language = $request->input('language' , '*');
        if ($language == '*')
            $participants = Participant::paginate(10);
        else {
            $dialects = Dialect::select('id')->where('language_id', $language)->get();
            $participants = Participant::whereIn('dialect_id', $dialects)->paginate(10);
        }

        $languages = Language::get();
        return view('dashboard.participants.index', compact('participants', 'languages'))->with('selectedlang', $language );
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function show(Participant $participant)
    {
        //
    }
}
