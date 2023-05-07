<?php

namespace App\Http\Resources;

use App\Models\Domain;
use Illuminate\Http\Resources\Json\JsonResource;

class DomainResource extends JsonResource
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
            'title' => $this->langApps[0]['pivot']['title']?? $this->title,
            'description' => $this->langApps[0]['pivot']['description']?? $this->description,
            'language_id' => $this->language_id,
            'level_count' => $this->level_count,        
            'levels' => $this->levels,
        ];
    }
    
}
