<?php

namespace App\Http\Controllers\Api;

use App\Models\Participant;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParticipantResource;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    function getById($id) {
        $participant = Participant::find($id);
        return new ParticipantResource( $participant);
    }

    function getByEmail($email) {
        $participant = Participant::where('email' , $email)->firstOrFail();
        return new ParticipantResource( $participant);
    }
}
