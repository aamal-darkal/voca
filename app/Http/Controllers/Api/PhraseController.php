<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PhraseResource;
use App\Models\Phrase;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Phrase  $phrase
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $phrase = Phrase::find($id);
        return new PhraseResource($phrase);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Phrase  $phrase
     * @return \Illuminate\Http\Response
     */
    public function edit(Phrase $phrase)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phrase  $phrase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phrase $phrase)
    {
        //
    }
}