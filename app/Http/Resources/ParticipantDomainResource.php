<?php

namespace App\Http\Resources;

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
    public static $key; //applang of participant
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->languages[0]['pivot']['title'] ?? $this->title,
            'description' => $this->languages[0]['pivot']['description'] ?? $this->description,
            'level_count' => $this->level_count,
            'order' => $this->order,
            'status' => $this->participants->first()? $this->participants->first()->pivot->status : null,
            'key' => self::$key,
            'levels' => ParticipantLevelResource::collection( $this->levels),
        ];
    }
}
