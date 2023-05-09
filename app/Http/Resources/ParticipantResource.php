<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantResource extends JsonResource
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
            'id' =>$this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => url( 'storage/participant-images/' . $this->avatar),
            'theme_app' => $this->theme_app,
            'is_admob' => $this->is_admob,
            'learn_word_count' => $this->learn_word_count,
            'learn_phrase_count' => $this->learn_phrase_count,            
            'lang_app' => $this->lang_app,
            'dialect_id' => $this->dialect_id
        ];
    }
}
