<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Phrase;
use App\Models\Domain;
use App\Models\Language;
use App\Models\Level;
use App\Models\PhraseWord;
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
        $phrases = Phrase::paginate(10);
        $languages = Language::get();
        $domains = Domain::get();
        $levels = Level::get();
        return view('dashboard.phrases.index', compact('phrases', 'languages', 'domains', 'levels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate(['level_id' => 'required']);
        $level = Level::find($request->level_id);
        $domain = $level->domain;
        $language = $domain->language;
        $word_types = $language->word_types;
        return view('dashboard.phrases.create', compact('word_types'))->with('level_id', $level->id);
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
            // 'word_count' => 'integer',
            'level_id' => 'exists:levels,id',
            'contents.*' => 'string',
            'word_type_id.*' => 'exists:word_types,id',
        ]);
        if (!$request->order)
            $request['order'] = Phrase::where('level_id', $request->level_id)->max('order') + 1;
        $phrase = Phrase::create($request->all());

        $content = $request->content;
        $wordContent = explode(" ", $content);
        for ($i = 0; $i <  count($wordContent); $i++) {
            $word = Word::where("content", $wordContent[$i])->first();
            $translations = [];
            // if word exists take its translation 
            if ($word) {
                // get first translation as field
                $translationRec = PhraseWord::where('word_id',  $word->id)->first();
                $translation = $translationRec ? $translationRec->translation : '';
                // get all translations to be as dataset                
                $translations = PhraseWord::where('word_id',  $word->id)->get()->unique('translation');

                // return $translations;
            } else {
                $word = Word::create(["content" => $wordContent[$i]]);
                $translation = '';
            }

            $phraseWord = PhraseWord::create([
                'phrase_id' => $phrase->id,
                'word_id' => $word->id,
                'translation' => $translation,
                'order' => $i+1
            ]);
            $words[] = $word;
            $phraseWords[] = $phraseWord;
            $allTranslations[] = $translations;
        }
        $word_types = WordType::get();
        return redirect()->route('words.edit')->with([
            'success' => 'phrase added, ready to complete its words',
            'phrase' => $phrase,
            'words' => $words,
            'allTranslations' => $allTranslations,
            'phraseWords' => $phraseWords,
            'word_types' => $word_types,
        ]);
    }


    /** 
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Phrase  $phrase
     * @return \Illuminate\Http\Response
     */
    public function edit(Phrase $phrase)
    {
        $wordTypes = $phrase->language->wordTypes;
        $words = $phrase->words;
        $allTranslations = [];
        $phraseWords = [];
        foreach ($words as $word) {
            $translations = PhraseWord::where('word_id',  $word->id)->get()->unique('translation');
            $allTranslations[] = $translations;

            $phraseWord = PhraseWord::where('phrase_id', $phrase->id)->where('word_id', $word->id)->first();
            $phraseWords[] = $phraseWord;
        }
        session()->put([
            'phrase' => $phrase,
            'words' => $words,
            'allTranslations' => $allTranslations,
            'phraseWords' => $phraseWords,
            'word_types' => $wordTypes,
        ]);
        return redirect()->route('words.edit');       
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
        return back()->with('success', 'phrase is successfuly deleted');
    }
}
