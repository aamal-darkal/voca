<?php

namespace App\Http\Resources;

use App\Models\Participant;
use App\Models\Phrase;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantPhraseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'translation' => $this->translation,
            'word_count' => $this->word_count,
            'order' => $this->order,
            'level_id' => $this->level_id,
            'status' => $this->participants->first() ? $this->participants->first()->pivot->status : null,
            'words' => ParticipantWordResource::collection($this->phraseWords),
        ];
    }
}
