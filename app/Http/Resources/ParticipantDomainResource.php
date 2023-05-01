<?php

namespace App\Http\Resources;

use App\Models\Level;
use App\Models\Participant;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantDomainResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'level_count' => $this->level_count,            
            'status' => $this->pivot->status,
            'levels' => ParticipantLevelResource::collection( $this->getLevels( $this->id , $this->pivot->participant_id)),
        ];  
    }
    function getLevels( $domain , $participant){
        return Participant::find($participant)->levels->where('domain_id' , $domain);
    }
}
