<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Language;
use App\Models\Level;
use App\Models\Phrase;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = $request->input('language' , '*');
        if ($lang == '*')
            $domains = Domain::paginate(10);
        else {
            $language = Language::find($lang);  
            $domains = $language->domains;
        }

        $languages = Language::get();

        return view('dashboard.domains.index', compact('domains', 'languages'))->with('selectedlang', $lang );
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = Language::get();
        return view('dashboard.domains.create' , compact('languages' ));
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
            'title' => 'required|string|max:255|unique:domains',
            'description' => 'string',
            'language_id' => 'required|exists:languages,id'
        ]);

        Domain::create($request->all());        
        return redirect()->route('domains.index')->with('success', 'Domain added successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Domain  $Domain
     * @return \Illuminate\Http\Response
     */
    public function edit(Domain $domain)
    {
        $languages = Language::get();
        return view('dashboard.domains.edit', compact('domain' , 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Domain  $Domain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Domain $domain)
    {
        // return $request;
        $request->validate([
            'title' => 'required|string|max:255|unique:domains,title,' . $domain->id,
            'description' => 'string',
                'language_id' => 'required|exists:languages,id'
        ]);
        $domain->update($request->all());
        return redirect()->route('domains.index')->with('success', 'Domain saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Domain  $Domain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domain $domain, Request $request)
    {
        if ($request->has('hard')) {
            // $phrases = $domain->phrases->modelkeys();
            // Phrase::wherein('id' , $phrases)->delete();

            // $levels = $domain->levels->modelkeys();
            // Level::wherein('id' , $levels)->delete();
            
            // $domain->delete();
            // return back()->with('success' , "Domain deleted successfully");
            return back()->with('error', 'Under development');

        } else {
            $levelCount = $domain->levels->count();
            if ($levelCount == 0)
                $domain->delete();
            else {
                $phraseCount = $domain->phrases->count();
                return back()->with('error', "can\'t delete Domain, because it has $levelCount levels and $phraseCount phrases,  if you want to delete all, choose hard delete ");
            }
        }
    }   
}
