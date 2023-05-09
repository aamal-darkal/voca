<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DomainFullTreeResource;
use App\Http\Resources\DomainResource;
use App\Models\Domain;
use App\Models\Level;
// use App\Models\DomainLocale as Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {                
        Domain::$langkey = $request->langkey;
        $domains = Domain::with('levels:id,domain_id')->with('langApps')->paginate(5);
        return DomainResource::collection($domains);
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
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function show( $id , Request $request)
    {
        Domain::$langkey = $request->langkey;
        $domain = Domain::with('levels:id,domain_id')->with('langApps')->find($id);
        return new DomainResource($domain);               
    } 
    /**
     * show full Tree of domain with its levels, phrase,words
     *
     * @param [id of domain] $id
     * @param Request $request
     * @return resource
     */
    function fullTree($id , Request $request){
        Domain::$langkey = $request->langkey;        
        Level::$langkey = $request->langkey;        
        $domain = Domain::with('levels','langApps')->find($id);
        return  new DomainFullTreeResource($domain);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function edit(Domain $domain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Domain $domain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domain $domain)
    {
        //
    }
}
