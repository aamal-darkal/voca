<?php

namespace App\Http\Controllers\Api;

use App\Models\Participant;
use App\Http\Controllers\Controller;
use App\Http\Resources\LevelResource;
use App\Http\Resources\ParticipantAllLevelsResource;
use App\Http\Resources\ParticipantDomainResource;
use App\Http\Resources\ParticipantLevelResource;
use App\Http\Resources\ParticipantResource;
use App\Models\Domain;
use App\Models\Language;
use App\Models\Level;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    function getByEmail(Request $request)
    {
        $email = $request->email;

        $participant = Participant::where('email', $email)->firstOrFail();
        return new ParticipantResource($participant);
    }

    public function show(Participant $participant)
    {
        return new ParticipantResource($participant);
    }

    /**
     * for all domains
     *
     * @param Participant $participant
     * @return void
     */
    public function DomainsStatus(Participant $participant)
    {
        Domain::$langkey =  Language::find($participant->lang_app)->key;
        Level::$langkey =  Language::find($participant->lang_app)->key;
        $domains = Domain::with('langApps')->get();
        ParticipantDomainResource::$participant = $participant->id;
        ParticipantAllLevelsResource::$participant = $participant->id;
        return ParticipantDomainResource::collection($domains);
    }

    /**
     * for certain level
     *
     * @param Participant $participant
     * @param Request $request
     * @return LevelResource instance
     */
    public function LevelStatus(Participant $participant, Request $request)
    {
        Level::$langkey =  Language::find($participant->lang_app)->key;

        $level_id = $request->level_id;
        $level = $participant->levels()->with('langApps', 'phrases')->where('level_id', $level_id)->get();
        return ParticipantLevelResource::collection($level);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:participants',
            'avatar' => 'image|max:2000|mimes:jpg,png,jpeg,bmp',
            'theme_app' => 'in:D,L',
            'is_admob' => 'boolean',
            'lang_app' => 'exists:languages,id',
            'dialect_id' => 'exists:dialects,id',
        ]);
        $participant = Participant::create($request->all());
        if ($participant) {
            if ($request->has('avatar')) {
                $avatar = $request->file('avatar');
                $fileName = $participant->id . '.' .  $avatar->extension();
                $avatar->storeAs('public/participant-images',  $fileName);
                $participant->avatar = $fileName;
            } else
                $participant->avatar = 'no-image.png';
            $participant->save();
            $domains = $participant->dialect->language->domains;

            $participant->domains()->syncWithPivotValues($domains,  ['status' => 'S']);
            return [
                'status' =>  'success',
                'message' => 'book saved participant',
                'id' => $participant->id,
            ];
        } else
            return [
                'status' =>  'error',
                'message' => 'error in adding participant'
            ];
    }
    public function update(Request $request, Participant $participant)
    {
        $request->validate([
            'name' => 'string|max:50',
            'email' => 'email|max:100|unique:participants,email,' . $participant->id,
            'avatar' => 'image|max:2000|mimes:jpg,png,jpeg,bmp',
            'theme_app' => 'in:D,L',
            'is_admob' => 'boolean',
            'lang_app' => 'exists:languages,id',
            'dialect_id' => 'exists:dialects,id',
        ]);
        if ($participant->update($request->all())) {
            if ($request->has('avatar')) {
                $avatar = $request->file('avatar');
                $fileName = $participant->id . '.' .  $avatar->extension();
                $avatar->storeAs('public/participant-images',  $fileName);
                $participant->avatar = $fileName;
                $participant->save();
            }
            return [
                'status' =>  'success',
                'message' => 'participant saved successfully'
            ];
        } else
            return [
                'status' =>  'error',
                'message' => 'error in updating participant'
            ];
    }

    public function attachDomain(Participant $participant, Request $request)
    {
        $domain = $request->domain;
        $isattached = $participant->domains()->where('id', $domain)->first();
        if ($isattached)
            $participant->domains()->updateExistingPivot($domain, ['status' => $request->status]);
        else
            $participant->domains()->attach($domain, ['status' => $request->status]);
        return [
            'status' => 'success',
        ];
    }

    public function attachLevel(Participant $participant, Request $request)
    {
        $level = $request->level;
        $isattached = $participant->levels()->where('id', $level)->first();
        if ($isattached)
            $participant->levels()->updateExistingPivot($level, ['status' => $request->status]);
        else
            $participant->levels()->attach($level, ['status' => $request->status]);
        return [
            'status' => 'success',
        ];
    }
    public function attachPhrase(Participant $participant, Request $request)
    {
        $phrase = $request->phrase;
        $isattached = $participant->phrases()->where('id', $phrase)->first();
        if ($isattached)
            $participant->phrases()->updateExistingPivot($phrase, ['status' => $request->status]);
        else
            $participant->phrases()->attach($phrase, ['status' => $request->status]);
        return [
            'status' => 'success',
        ];
    }
}
