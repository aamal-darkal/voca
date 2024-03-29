<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Language;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = $request->language;

        $domains = Domain::when($lang , function($q) use ($lang) {
            return $q->where('language_id' , $lang);
        })->with('language')->get();

        $languages = Language::get();

        return view('dashboard.domains.index', compact('domains', 'languages'))->with('selectedlang', $lang);
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return json
     */
    public function getDomains(Request $request)
    {
        $language = $request->language;
        $domains = Domain::when($language != 'all' , function($q) use ($language) {
            return $q->where('language_id' , $language);
        })->orderby('order')->get();

        return $domains;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = Language::get();
        return view('dashboard.domains.create', compact('languages'));
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
            'language_id' => 'required|exists:languages,id',
            'title' => 'required|string|max:100|unique:domains',
            'description' => 'string|max:255',
            'languages.*' => 'exists:languages,id',
            'titles.*' => 'string|max:100',
            'descriptions.*' => 'string|max:255',
        ]);

        //get max order if it is not supplied
        if (!$request->order)
            $request['order'] = Domain::where('language_id', $request->language_id)->max('order') + 1;
        $domain = Domain::create($request->all());
       
        //get titles & descriptions for all languages
        $titles = $request->titles;
        $languages = $request->languages;
        $descriptions = $request->descriptions;

        if ($titles) {
            foreach ($titles as $i => $title) { 
                $domain->languages()->attach($languages[$i], ['title' => $title,  'description' => $descriptions[$i]]);
            }
        }
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
        return view('dashboard.domains.edit', compact('domain', 'languages'));
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
            'language_id' => 'required|exists:languages,id',
            'title' => 'required|string|max:100|unique:domains,title,' . $domain->id,
            'description' => 'string|max:255',
            'languages.*' => 'exists:languages,id',
            'titles.*' => '|string|max:100',
            'descriptions.*' => 'string|max:255',
        ]);
        $domain->update($request->all());

        $titles = $request->titles;
        $languages = $request->languages;
        $descriptions = $request->descriptions;

        $domain->languages()->detach();
        if ($titles) {
            foreach ($titles as $i => $title) {
                $domain->languages()->attach($languages[$i], ['title' => $title,  'description' => $descriptions[$i]]);
            }
        }
        return redirect()->route('domains.index')->with('success', 'Domain saved successfully');
    }


    /**
     * Show the form for removing the specified resource.
     * 
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function delete(Domain $domain)
    {
        $participantCount = $domain->participants()->count();
        $levelCount = $domain->levels()->count();
        return view('dashboard.domains.delete', compact('domain', 'participantCount', 'levelCount'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domain $domain)
    {
        $participantCount = $domain->participants()->count();
        $levelCount = $domain->levels()->count();

        if ($participantCount == 0 && $levelCount == 0) {
            $domain->delete();
            return redirect()->route('domains.index')->with('success', "domain deleted successfully");
        } else
            return redirect()->route('domains.index')->with('error', "can't remove domain $domain->title, because there are $participantCount participant related to it and has $levelCount levels");
    }
}
 