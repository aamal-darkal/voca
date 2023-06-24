<?php

namespace App\Http\Resources;

use App\Models\Participant;
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
        return  [        
            'id' => $this->id,
            'title' => $this->languages[0]['pivot']['title']?? $this->title,
            'description' => $this->languages[0]['pivot']['description']?? $this->description,
            'status' => $this->participants->first()? $this->participants->first()->pivot->status : null,
            'phrase_count' => $this->phrase_count,
            'order' => $this->order,  
            'domain_id'=> $this->domain_id, 
            'pastCount' =>  $this->participants->first()?$this->participants->first()->phrases()->where('level_id' , $this->id)->wherein('status' , ['C','X'] )->count() : 0,                     
            'phrases' =>  ParticipantPhraseResource::collection( $this->whenloaded('phrases')),
        ];        
    } 
}
