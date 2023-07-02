<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dialect;
use App\Models\Participant;
use App\Models\WordType;

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
            'name' => 'required|string|max:20|unique:languages',
            'key' => 'required|string|max:2|min:2|unique:languages',
            'locales.*' => 'required|string|max:5|min:5',
            'keys.*' => 'required|string|max:50',
            'names.*' => 'required|string|max:50',
        ]);
        $language = Language::create($request->all());
        //create dialects
        if ($request->has('locales')) {
            $locales = $request->locales;
            $keys = $request->keys;
            foreach ($locales as $i => $locale) {
                Dialect::create(['locale' => $locale, 'key' => $keys[$i], 'language_id' => $language->id]);
            }
        }
        //create WordTypes
        if ($request->has('names')) {
            $names = $request->names;
            foreach ($names as $name) {
                WordType::create(['name' => $name, 'language_id' => $language->id]);
            }
        }
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
        return view('dashboard.languages.view', compact('language'));
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
            'name' => 'required|string|max:20|unique:languages,name,' . $language->id,
            'key' => 'required|string|max:2|min:2|unique:languages,key,' . $language->id,
            'locales.*' => 'max:5',
            'keys.*' => 'max:50',
            'names.*' => 'max:50',
        ]);
        $errors = [];
        $language->update($request->all());

        if ($request->has('locales')) {
            $ids = $request->dialectIds;
            $states = $request->dialectStates;
            $locales = $request->locales;
            $keys = $request->keys;

            for ($i = 0; $i < count($locales); $i++) {
                if ($states[$i] == 'new') {
                    if ($locales[$i] && $keys[$i])
                        Dialect::create(['locale' => $locales[$i], 'key' => $keys[$i], 'language_id' => $language->id]);
                } elseif ($states[$i] == 'del' && $ids[$i] != 'new') {
                    $participantStatusCount = Dialect::find($ids[$i])->participants()->count();
                    if ($participantStatusCount == 0)
                        Dialect::find($ids[$i])->delete();
                    else
                        $errors['dialect'] = "can't delete dialect, because there are $participantStatusCount participants related to it";
                } elseif ($states[$i] == 'old') {
                    if ($locales[$i] && $keys[$i]) {
                        $dialect = Dialect::find($ids[$i]);
                        $dialect->update(['locale' => $locales[$i], 'key' => $keys[$i], 'language_id' => $language->id]);
                    }
                }
            }
        }

        if ($request->has('names')) {
            $ids = $request->wordTypesIds;
            $states = $request->wordTypesStates;
            $names = $request->names;

            for ($i = 0; $i < count($names); $i++) {

                if ($states[$i] == 'new') {
                    if ($names[$i])
                        WordType::create(['name' => $names[$i], 'language_id' => $language->id]);
                } elseif ($states[$i] == 'del' && $ids[$i] != 'new') {
                    $wordsCount = WordType::find($ids[$i])->words()->count();

                    if ($wordsCount == 0)
                        WordType::find($ids[$i])->delete();
                    else
                        $errors['wordType'] = "can't delete word type, because there are $wordsCount words related to it";
                } elseif ($states[$i] == 'old') {
                    if ($names[$i]) {
                        $dialect = WordType::find($ids[$i]);
                        $dialect->update(['name' => $names[$i], 'language_id' => $language->id]);
                    }
                }
            }
        }
        if (count($errors) == 0)
            return redirect()->route('languages.index')->with('success', 'Language saved successfully');
        else {
            foreach ($errors as $key => $value)
                $message = "$key: $value -";
            return redirect()->route('languages.index')->with('error', $message);
        }
    }

    /**
     * Show the form for removing the specified resource.
     * 
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function delete(Language $language)
    {
        $participantCount = $language->participants()->count();
        $domainCount = $language->domains()->count();
        $language = Language::with(['dialects', 'wordTypes'])->find($language)->first();
        return view('dashboard.languages.delete', compact('language', 'participantCount', 'domainCount'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        $participantCount = $language->participants()->count();
        if ($participantCount == 0) {
            $language->dialects()->delete();
            $language->wordTypes()->delete();
            $language->delete();
            return redirect()->route('languages.index')->with('success', "language deleted successfully");
        } else
            return redirect()->route('languages.index')->with('error', "can remove language $language->name with $participantCount participantCount");
    }
}
