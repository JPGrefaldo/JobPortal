<?php

namespace App\Actions\Endorsement;

use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
use App\Models\Position;
use App\Models\User;
use App\Utils\StrUtils;

class CreateEndorsementRequest
{
    /**
     * @param User $user
     * @param Position $position
     * @param string $email
     * @param string $message
     * @param string $request_owner
     * @return Endorsement
     */
    public function execute(User $user, Position $position, $email, $message, $request_owner) : Endorsement
    {
        $crewPosition = CrewPosition::where('crew_id', $user->crew->id)
            ->where('position_id', $position->id)
            ->firstOrFail();

        $endorser = app(CreateOrGetEndorserByEmail::class)->execute($email);

        $request = EndorsementRequest::create([
            'endorsement_endorser_id' => $endorser->id,
            'token'                   => StrUtils::createRandomString(),
            'message'                 => $message,
        ]);

        $request->endorser->update([
            'request_owner' => $request_owner,
        ]);

        return Endorsement::create([
            'crew_position_id'       => $crewPosition->id,
            'endorsement_request_id' => $request->id,
            'approved_at'            => null,
        ]);
    }
}
