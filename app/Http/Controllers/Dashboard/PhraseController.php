<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Phrase;
use App\Models\Domain;
use App\Models\Language;
use App\Models\Level;
use App\Models\PhraseWord;
use App\Models\Word;
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
        // $phrases = Phrase::paginate(7);
        $languages = Language::get();       
        return view('dashboard.phrases.index', compact('languages'));
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return json
     */
    public function getPhrases(Request $request)
    {
        $level = $request->level;
        $domain = $request->domain;
        $language = $request->language;

        $phrases = Phrase::when($level != 'all', function ($q) use ($level) {
            return $q->where('level_id', $level);
        }, function ($q) use ($domain, $language) {
            return $q->when($domain != 'all', function ($q) use ($domain) {
                return $q->whereHas('level', function ($q) use ($domain) {
                    return $q->where('domain_id', $domain);
                });
            },  function ($q) use ($language) {
                return $q->when($language != 'all', function ($q) use ($language) {
                    return $q->whereHas('domain', function ($q) use ($language) {
                        return $q->where('language_id', $language);
                    });
                });
            });
        })->orderby('order')->paginate(7);
    // })->orderby('order')->get();
        return $phrases;
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
        $levelTitle = $level->title;
        $domain = $level->domain;
        $language = $domain->language;
        $word_types = $language->word_types;
        return view('dashboard.phrases.create', compact('word_types' , 'levelTitle'))->with('level_id', $level->id);
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
            'level_id' => 'exists:levels,id',
            'contents.*' => 'string',
            'word_type_id.*' => 'exists:word_types,id',
        ]);

        /** ******** Save phrase ************ */
        //if order is not sent, calculate it
        if (!$request->order)
            $request['order'] = Phrase::where('level_id', $request->level_id)->max('order') + 1;

        $content = $request->content;
        $wordContent = explode(" ", $content);
        $request['word_count'] = count($wordContent);
        $phrase = Phrase::create($request->all());

        /** ******** Save  words & its translation *********** */
        //for each word save it with its translation
        for ($i = 0; $i <  count($wordContent); $i++) {
            $word = Word::where("content", $wordContent[$i])->first();
            $translations = [];
            // if word exists take its translation 
            if ($word) {
                // get first translation as field
                $translationRec = PhraseWord::where('word_id',  $word->id)->first();
                $translation = $translationRec ? $translationRec->translation : '';
                // get all translations to be as a dataset                
                $translations = PhraseWord::where('word_id',  $word->id)->get()->unique('translation');
            } else {
                // if word first time added, add it to words table
                $word = Word::create(["content" => $wordContent[$i]]);
                $translation = '';
            }

            $phraseWord = PhraseWord::create([
                'phrase_id' => $phrase->id,
                'word_id' => $word->id,
                'translation' => $translation,
                'order' => $i + 1
            ]);
            $words[] = $word;
            $phraseWords[] = $phraseWord;
            $allTranslations[] = $translations;
        }
        $wordTypes = $phrase->language->wordTypes;
        session()->put([
            'success' => 'phrase added, ready to complete its words',
            'phrase' => $phrase,
            'words' => $words,
            'allTranslations' => $allTranslations,
            'phraseWords' => $phraseWords,
            'wordTypes' => $wordTypes,
        ]);
        return to_route('words.edit');
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
            'wordTypes' => $wordTypes,
        ]);
        return redirect()->route('words.edit');
    }


    /**
     * Show the form for removing the specified resource.
     * 
     * @param  \App\Models\Phrase  $phrase
     * @return \Illuminate\Http\Response
     */
    public function delete(Phrase $phrase)
    {
        $participantCount = $phrase->participants()->count();
        Phrase::with('words')->find($phrase);
        return view('dashboard.phrases.delete', compact('phrase', 'participantCount'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phrase  $phrase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phrase $phrase)
    {
        $participantCount = $phrase->participants()->count();

        if ($participantCount == 0) {
            $phrase->delete();
            return redirect()->route('phrases.index')->with('success', "phrase deleted successfully");
        } else
            return redirect()->route('phrases.index')->with('error', "can remove phrase $phrase->content with $participantCount participantCount");
    }
}
