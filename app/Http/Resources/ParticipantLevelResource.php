<?php

namespace App\Http\Resources;

use App\Models\Phrase;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantLevelResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $participant = $this->participants->first();
        return  [
            'id' => $this->id,
            'title' => $this->languages ? $this->languages[0]['pivot']['title'] ?? $this->title : $this->title,
            'description' => $this->languages ? $this->languages[0]['pivot']['description'] ?? $this->description : $this->description,
            'status' => $participant ? $participant->pivot->status : null,
            'phrase_count' => $this->phrase_count,
            'order' => $this->order,
            'domain_id' => $this->domain_id,
            'pastCount' =>  $participant ? $participant->phrases()->where('level_id', $this->id)->wherein('status', ['C', 'X'])->count() : 0,
            'phrases' => $this->when($this->relationLoaded('phrases'), ParticipantPhraseResource::collection($this->phraseCollection($this->phrases, $participant))),
        ];
    }
    function phraseCollection($phrases, $participant)
    {
        if ($participant)
            $participant_id = $participant->id;
        else
            $participant_id = null;
        $nPhrases = [];
        foreach ($phrases as $phrase) {
            $nphrase = Phrase::with('phraseWords')
                ->with('phraseWords.word')
                ->with('phraseWords.participants', function ($query) use ($participant_id) {
                    $query->where('id', $participant_id);
                })
                ->where('id', $phrase->id)->first();
            $nPhrases[] = $nphrase;
        }

        return $nPhrases;
    }
}
