<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Phrase;
use App\Models\PhraseWord;
use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Word  $word
     * @return \Illuminate\Http\Response
     */
    public function edit(Word $word)
    {
        $phrase = session()->get('phrase');
        $words = session()->get('words');
        $allTranslations = session()->get('allTranslations');
        $phraseWords = session()->get('phraseWords');
        $wordTypes = session()->get('wordTypes');
        return view('dashboard.words.edit', compact('phrase', 'words','allTranslations' , 'phraseWords' ,'wordTypes'));
    }   


    /**
     * save phrase words.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request )
    {
        //Save phrase translation
        $phrase = Phrase::find($request->phrase_id);
        $phrase->translation = $request->translation;
        $phrase->save();
        
        //save words info
        $wordIds =  $request->word_ids;
        $wordTypes = $request->wordTypes;
        for($i = 0 ; $i < count($wordIds) ; $i++) {
            $word = Word::find( $wordIds[$i]);
            $word->word_type_id = $wordTypes[$i];
            $word->save();
        }
        $phraseWorIds = $request->phraseWord_ids;
        $translations = $request->translations;

        for($i = 0 ; $i < count($phraseWorIds) ; $i++) {
            $phraseWord = PhraseWord::find( $phraseWorIds[$i]);
            $phraseWord->translation = $translations[$i] ;
            $phraseWord->save();
        }
        session()->forget([
            'phrase' , 'words', 'allTranslations', 'phraseWords', 'word_types',
        ]);
        return redirect()->route('phrases.index')->with('success' , 'Words Saved successfully ');
    }
}
