<?php

namespace App\Http\Controllers\Api;

use App\Models\Participant;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParticipantResource;
use App\Http\Resources\ParticipantDomainResource;
use App\Http\Resources\ParticipantLevelResource;
use App\Http\Resources\ParticipantPhraseResource;
use App\Http\Resources\ParticipantWordResource;
use App\Models\Domain;
use App\Models\Language;
use App\Models\Level;
use App\Models\Phrase;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

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
    /*********************** Status ********************************* */
    /**
     * for all domains
     *
     * @param Participant $participant
     * @return void
     */
    public function domainsStatus(Participant $participant)
    {
        $langkey =  Language::find($participant->lang_app)->key;
        $domains = Domain::with([
            'levels',
            'levels.languages' => function ($query) use ($langkey) {
                $query->where('key', $langkey);
            },
            'languages' => function ($query) use ($langkey) {
                $query->where('key', $langkey);
            },
            'participants' => function($query) use ($participant){
                $query->where('id', $participant->id);
            }
        ])->get();
        return ParticipantDomainResource::collection($domains);
    }

    /**
     * for certain level
     *
     * @param Participant $participant
     * @param Request $request
     * @return LevelResource collection as tree
     */
    public function levelStatus(Participant $participant, Request $request)
    {
        $langkey =  Language::find($participant->lang_app)->key;

        $level_id = $request->level_id;
        $level = Level::with([
            'languages' => function ($query) use ($langkey) {
                $query->where('key', $langkey);
            },
            'phrases',
            'phrases.words',                            
        ])->find($level_id);
        ParticipantWordResource::$participant = $participant->id;
        if ($level)
            return new ParticipantLevelResource($level);
        else
            return [
                'fail' => 'Level id not found',
            ];
    }
    /**
     * for certain level
     *
     * @param Participant $participant
     * @param Request $request
     * @return PhraseResource collection as tree
     */
    public function phraseStatus(Participant $participant, Request $request)
    {

        $phrase_id = $request->phrase_id;

        $phrase = Phrase::with('words')->where('id', $phrase_id)->get();
        ParticipantWordResource::$participant = $participant->id;
        return ParticipantPhraseResource::collection($phrase);
    }

    /* **************************** Attachment ************************************** */
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
        $this->handlePhrase($participant, $request->phrase, $request->status);
        return [
            'status' => 'success',
        ];
    }
    public function attachWord(Participant $participant, Request $request)
    {

        $this->handleWord($participant, $request->phrase_word_id, $request->status);
        return [
            'status' => 'success',
        ];
    }

    public function handlePhraseTree(Participant $participant, Request $request)
    {
        $phrase_id = $request->phrase_id;
        $phrase = Phrase::find($phrase_id);
        $language_id = $phrase->domain->language_id;
        $next_phrase_id = Language::find($language_id)->phrases()->where('phrases.order', '>', $phrase->order)->orderby('phrases.order')->first();
        $next_phrase_id = $next_phrase_id ? $next_phrase_id->id : null;
        $this->handlePhrase($participant, $phrase_id, $request->phrase_status);
        $words =  $request->words;
        foreach ($words as $word) {
            $this->handleWord($participant, $word['phrase_word_id'], $word['phrase_word_status']);
        }
        return [
            'status' => 'success',
            'next_phrase_id' => $next_phrase_id,
        ];
    }

    function handlePhrase(Participant $participant, $phrase_id, $status)
    {
        $isattached = $participant->phrases()->where('id', $phrase_id)->first();
        if ($isattached)
            $participant->phrases()->updateExistingPivot($phrase_id, ['status' => $status]);
        else
            $participant->phrases()->attach($phrase_id, ['status' => $status]);
    }

    function handleWord(Participant $participant,  $phrase_word_id, $status)
    {
        $isattached = $participant->words()->where('id', $phrase_word_id)->first();
        if ($isattached)
            $participant->words()->updateExistingPivot($phrase_word_id, ['status' => $status]);
        else
            $participant->words()->attach($phrase_word_id, ['status' => $status]);
    }
}
