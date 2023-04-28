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
        $domain = Domain::find($request->domain);
        session(['domain' => $domain->id]);
        $levels = $domain->levels;
        return view('dashboard.levels.index', compact('levels' ))->with('domain' , $domain->title);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $domain = session('domain');
        return view('dashboard.levels.create' , compact('domain'));
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
            'title' => 'required|string|max:255|unique:levels',
            'description' => 'string',
        ]);
        
        $request['order'] =  Level::max('order') + 1 ;
        Level::create($request->all());  

        $domain = Domain::find(session('domain'));
        $domain->level_count++; 
        $domain->save();
        return redirect()->route('levels.index' , ['domain' => session('domain')])->with('success', 'level added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function show(level $level)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit(level $level)
    {
        $domain = session('domain');
        return view('dashboard.levels.edit', compact('level' , 'domain'));
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
        ]);
        $level->update($request->all());
        return redirect()->route('levels.index' , ['domain' => session('domain')])->with('success', 'level saved successfully');
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
            if ($phraseCount == 0)
                $level->delete();
            else {
                $wordCount = $level->words->count();
                return back()->with('error', "can\'t delete level, because it has $phraseCount levels and $wordCount phrases,  if you want to delete all, choose hard delete ");
            }
        }
    }   
}
