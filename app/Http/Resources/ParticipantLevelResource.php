<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantLevelResource extends JsonResource
{
    public static $participant;
    public static $withphrase;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $level =  [        
            'id' => $this->id,
            'title' => $this->langApps[0]['pivot']['title']?? $this->title,
            'description' => $this->langApps[0]['pivot']['description']?? $this->description,
            'status' => $this->getStatus($this),           
            'phrase_count' => $this->phrase_count,
            'order' => $this->order,  
            'domain_id'=> $this->domain_id,   
        ];
        if (SELF::$withphrase)         
            $level['phrases'] = ParticipantPhraseResource::collection( $this->phrases);
        return $level;
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
