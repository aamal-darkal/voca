<?php

namespace App\Http\Resources;

use App\Models\PhraseWord;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantWordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $participant;

    public function toArray($request)
    {
        return [
            'word_id' => $this->word_id,
            'content' => $this->word ? $this->word->content : null,
            'word_type' => $this->word ? ($this->word->wordType ? $this->word->wordType->name : null) : null,
            'phrase_word_id' => $this->id,
            'translation' => $this->translation,
            'order' => $this->order,
            'status' => $this->participants->first() ? $this->participants->first()->pivot->status : null,
        ];
    }
}
