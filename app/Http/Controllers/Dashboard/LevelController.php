<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Level;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Language;
use App\Models\Phrase;

class levelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $domain_id = $request->domain;
        $domain = Domain::find($domain_id);
        $levels = Level::where('domain_id' , $domain_id)->orderBy('order')->get();
        return view('dashboard.levels.index', compact('levels'))->with('domain', $domain);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $domain = $request->domain;
        $languages = Language::get();
        return view('dashboard.levels.create', compact('domain', 'languages'));
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
            'domain_id' => 'required|exists:domains,id',
            'title' => 'required|string|max:255|unique:levels',
            'description' => 'string',
            // 'order' => 'integer',
            'languages.*' => 'exists:languages,id',
            'titles.*' => 'string|max:100',
            'descriptions.*' => 'string|max:255',
        ]);

        if (!$request->order)
            $request['order'] = Level::where('domain_id' , $request->domain_id)->max('order') + 1;
        $level = Level::create($request->all());

        $titles = $request->titles;
        $languages = $request->languages;
        $descriptions = $request->descriptions;     

        if ($titles) {
            for ($i = 0; $i < count($titles); $i++) {
                $level->languages()->attach($languages[$i], ['title' => $titles[$i],  'description' => $descriptions[$i]]);
            }
        }

        $domain = Domain::find($request->domain_id);
        $domain->level_count++;
        $domain->save();
        return redirect()->route('levels.index', ['domain' => $domain->id])->with('success', 'level added successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit(level $level, Request $request)
    {
        $languages = Language::get();
        return view('dashboard.levels.edit', compact('level', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Level $level)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:levels,title,' . $level->id,
            'description' => 'string',
            // 'order' => 'integer',
            'languages.*' => 'exists:languages,id',
            'titles.*' => 'string|max:100',
            'descriptions.*' => 'string|max:255',
        ]);
        $level->update($request->all());

        $titles = $request->titles;
        $languages = $request->languages;
        $descriptions = $request->descriptions;

        $level->languages()->detach();
        if ($titles) {
            for ($i = 0; $i < count($titles); $i++) {
                $level->languages()->attach($languages[$i], ['title' => $titles[$i],  'description' => $descriptions[$i]]);
            }
        }
        return redirect()->route('levels.index', ['domain' => $level->domain_id])->with('success', 'level saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level, Request $request)
    {
        if ($request->has('hard')) {
            // $phrases = $level->phrases->modelkeys();
            // Phrase::wherein('id' , $phrases)->delete();

            // $levels = $level->levels->modelkeys();
            // Level::wherein('id' , $levels)->delete();

            // $level->delete();
            // return back()->with('success' , "level deleted successfully");
            return back()->with('error', 'Under development');
        } else {
            $phraseCount = $level->phrases->count();
            if ($phraseCount == 0) {
                $domain = Domain::find($level->domain_id);
                $domain->level_count--;
                $domain->save();
                $level->delete();
                return redirect()->route('levels.index', ['domain' => $domain])->with('success', 'level deleted successfully');
            } else {
                $wordCount = $level->words->count();
                return back()->with('error', "can\'t delete level, because it has $phraseCount levels and $wordCount phrases,  if you want to delete all, choose hard delete ");
            }
        }
    }
}
