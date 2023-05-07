<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dialect;
use App\Models\Participant;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::get();
        return view('dashboard.languages.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.languages.create');
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
            'name' => 'required|string|max:15|unique:languages',
            'key' => 'required|string|max:2|min:2|unique:languages',
            'locales.*' => 'required|max:15',
            'keys.*' => 'required|max:5|min:5'
        ]);
        $language = Language::create($request->all());
        if ($request->has('locales')) {
            $locales = $request->locales;
            $keys = $request->keys;
            for ($i = 0; $i < count($locales); $i++) {
                Dialect::create(['locale' => $locales[$i], 'key' => $keys[$i], 'language_id' => $language->id]);
            }
        } else
            Dialect::create(['lacale' => $language->name]);
        return redirect()->route('languages.index')->with('success', 'Language added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        return view('dashboard.languages.view' , compact('language'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        return view('dashboard.languages.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        // return $request;
        $request->validate([
            'name' => 'required|string|max:255|unique:languages,name,' . $language->id,
            'locales.*' => 'required',
            'keys.*' => 'required|max:5|min:5'
        ]);
        $language->update($request->all());

        if ($request->has('locales')) {
            $ids = $request->ids;
            $locales = $request->locales;
            $keys = $request->keys;
            $states = $request->states;
            for ($i = 0; $i < count($locales); $i++) {
                if ($states[$i] == 'new')

                    Dialect::create(['locale' => $locales[$i], 'key' => $keys[$i], 'language_id' => $language->id]);
                elseif ($states[$i] == 'del' && $ids[$i] != 'new') {
                    $dialect = Dialect::find($ids[$i])->delete();
                } elseif ($states[$i] == 'old') {
                    $dialect = Dialect::find($ids[$i]);
                    $dialect->update(['locale' => $locales[$i], 'key' => $keys[$i], 'language_id' => $language->id]);
                }
            }
        } else
            Dialect::create(['lacale' => $language->name]);
        return redirect()->route('languages.index')->with('success', 'Language saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language, Request $request)
    {
        if ($request->has('hard')) {
            // $participants = $language->participants->modelkeys();
            // Participant::wherein('id' , $participants)->delete();

            // $dialects = $language->dialects->modelkeys();
            // Dialect::wherein('id' , $dialects)->delete();
            
            // $language->delete();
            // return back()->with('success' , "language deleted successfully");
            return back()->with('error', 'Under development');

        } else {

            $dialectCount = $language->dialects->count();
            if ($dialectCount == 0)
                $language->delete();
            else {
                $participants = $language->participants->count();
                return back()->with('error', "can\'t delete language, because it has $dialectCount dialects and $participants participants,     if you want to delete all, choose hard delete ");
            }
        }
    }   
}
