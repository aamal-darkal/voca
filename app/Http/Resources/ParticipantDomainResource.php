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
    public static $participant;
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->langApps[0]['pivot']['title'] ?? $this->title,
            'description' => $this->langApps[0]['pivot']['description'] ?? $this->description,
            'level_count' => $this->level_count,
            'order' => $this->order,
            'status' => $this->getStatus( $this),
            'key' => Participant::find(SELF::$participant)->dialect->language->key,
            'levels' => ParticipantAllLevelsResource::collection( $this->levels),
        ];
    }
   

    function getStatus($domain)
    {
        $domainParticipant = $domain->participants()->where('id', Self::$participant)->first();
        if ($domainParticipant)
            return $domainParticipant->pivot->status;
        else
            return null;
    }
}
