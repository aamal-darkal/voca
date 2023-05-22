<?php

namespace App\Http\Resources;

use App\Models\PhraseWord;
use Illuminate\Http\Resources\Json\JsonResource;

class WordResource extends JsonResource
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
            'word_id' => $this->id, 
            'content' => $this->content,
            'word_type' => $this->wordType->name,
            'phrase_word_id' => $this->pivot->id, 
            'translation' => $this->pivot->translation,
            'order' => $this->pivot->order,
            'status' => $this->getStatus($this->pivot->id),
        ];
    }
    private function getStatus($phrase_word_id){

        $wordParticipant =PhraseWord::find($phrase_word_id)->participants()->where('id', Self::$participant)->first();

        if ($wordParticipant)
            return $wordParticipant->pivot->status;
        else
            return null;
    }
}
