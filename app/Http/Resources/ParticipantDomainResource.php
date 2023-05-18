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
            'status' => $this->getStatus( $this),
            // 'levels' => ParticipantAllLevelsResource::collection( $this->getLevels( $this->id , $this->pivot->participant_id)),
            'levels' => ParticipantAllLevelsResource::collection( $this->levels),
        ];
    }
    // function getLevels($domain, $participant)
    // {
    //     return Participant::find($participant)->levels->where('domain_id', $domain);
    // }

    function getStatus($domain)
    {
        $domainParticipant = $domain->participants()->where('id', Self::$participant)->first();
        if ($domainParticipant)
            return $domainParticipant->pivot->status;
        else
            return null;
    }
}
