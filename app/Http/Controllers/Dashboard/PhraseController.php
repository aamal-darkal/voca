<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Phrase;
use App\Models\Domain;
use App\Models\Language;
use App\Models\Level;
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
        $wordTypes = $language->wordTypes;
        return view('dashboard.phrases.create', compact('wordTypes'))->with('level_id', $level->id);
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
        $contentWords = explode(" ", $content);
        $words = [];
        for ($i = 1; $i <  count($contentWords); $i++) {
            $word = Word::where("content", $contentWords[$i])->first();            
            if ($word) {
                $wordInfo['translation'] = $word['content']->phrases->first()->pivot->tranlation;
            } else {
                $word = Word::create(["content" => $contentWords[$i]]); 
                $wordInfo['translation'] = '';
            }
            $wordInfo['content'] = $contentWords[$i];
            $wordInfo['order'] = $i;
            $wordInfos[] = $wordInfo;
            $word->phrases()->attach(
                $phrase,
                [
                    'translation' => $wordInfo['translation'],
                    'order' => $wordInfo['order'],
                ]
            );
        }
        session()->flush('success', 'phrase added, ready to complete its words');
        return view('dashboard.words.edit', compact('phrase', 'wordInfo'));
    }


    /** 
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Phrase  $phrase
     * @return \Illuminate\Http\Response
     */
    public function edit(Phrase $phrase)
    {
        $wordTypes = $phrase->level->domain->language->wordTypes;
        $words = $phrase->words;
        return view('dashboard.phrases.edit', compact('phrase', 'wordTypes', 'words'));
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
            'level_id' => 'exists:levels,id',
            'contents.*' => 'string',
            'word_type_id.*' => 'exists:word_types,id',
        ]);
        $phrase->update($request->all());
        $phrase->words()->delete();

        $contents = $request->contents;
        $translations = $request->translations;
        $wordTypes = $request->wordTypes;

        for ($i = 0; $i < count($contents); $i++) {
            $word = Word::create([
                'content' => $contents[$i],
                'word_type_id' => $wordTypes[$i],
            ]);
            $word->phrases()->attach($phrase, [
                'translation' => $translations[$i],
                'order' => $i,
            ]);
        }
        return redirect()->route('phrases.index')->with('success', 'phrase saved successfully');
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
