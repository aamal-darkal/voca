<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantAllLevelsResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->langApps[0]['pivot']['title']?? $this->title,
            'description' => $this->langApps[0]['pivot']['description']?? $this->description,
            'phrase_count' => $this->phrase_count,
            'order' => $this->order,
            'status' => $this->getStatus($this),

        ];
    }
    function getStatus($level)
    {

        $levelParticipant = $level->participants()->where('id', Self::$participant)->first();
        if ($levelParticipant)
            return $levelParticipant->pivot->status;
        else
            return null;
    }
}
