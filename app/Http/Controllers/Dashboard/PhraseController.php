<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Phrase;
use App\Models\Domain;
use App\Models\Language;
use App\Models\Level;
use App\Models\Word;
use App\Models\WordType;
use Illuminate\Http\Request;

class PhraseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return "no error";
        $phrases = Phrase::paginate(10);
        $languages = Language::get();
        $domains = Domain::get();
        $levels = Level::get();
        return view('dashboard.phrases.index', compact('phrases','languages' , 'domains' , 'levels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    { 
        $request->validate(['level_id' => 'required']);
        $level = Level::find( $request->level_id);
        $domain = $level->domain; 
        $language = $domain->language;         
        $wordTypes = $language->wordTypes;  
        return view('dashboard.phrases.create' , compact( 'wordTypes'))->with('level_id' , $level->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'word_count' => 'integer',
            'level_id' =>'exists:levels,id',
            'contents.*' => 'string',            
            'word_type_id.*' => 'exists:word_types,id',            
        ]);
        $phrase = Phrase::create($request->all());
        $contents = $request->contents;
        $translations = $request->translations;
        $wordTypes = $request->wordTypes;

        for($i = 0 ; $i < count($contents) ; $i++) {
            $word = Word::create([
                'content' => $contents[$i],
                'word_type_id' => $wordTypes[$i],
            ]);
            $word->phrases()->attach($phrase , [
                                                'translation' => $translations[$i] ,
                                                'order' => $i ,
                                                ]);
        }
        return back()->with('success', 'phrase added successfully');             
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Phrase  $phrase
     * @return \Illuminate\Http\Response
     */
    public function edit(Phrase $phrase)
    {
        $words = $phrase->words->withPivot();
        return view('dashboard.phrases.edit' , compact('phrase' ,'words'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Phrase  $phrase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Phrase $phrase)
    {
        $request->validate([
            'content' => 'required|string',
            'word_count' => 'integer',
            'level_id' =>'exists:levels,id',
            'contents.*' => 'string',            
            'word_type_id.*' => 'exists:word_types,id',            
        ]);
        $phrase = Phrase::create($request->all());
        $contents = $request->contents;
        $translations = $request->translations;
        $wordTypes = $request->wordTypes;

        for($i = 0 ; $i < count($contents) ; $i++) {
            $word = Word::create([
                'content' => $contents[$i],
                'word_type_id' => $wordTypes[$i],
            ]);
            $word->phrases()->attach($phrase , [
                                                'translation' => $translations[$i] ,
                                                'order' => $i ,
                                                ]);
        }
        return back()->with('success', 'phrase added successfully');             

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phrase  $phrase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phrase $phrase)
    {
        $phrase->delete();
        return back()->with('success' , 'phrase is successfuly deleted');
    }
}
