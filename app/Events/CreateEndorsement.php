<?php

namespace App\Events;

use App\Mail\EndorsementRequestEmail;
use App\Models\Endorsement;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CreateEndorsement
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $email;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($endorsement)
    {
        $data = Endorsement::with([
            'request',
            'request.endorser',
            'request.endorser.user',
        ])->whereEndorsementRequestId($endorsement->endorsement_request_id)->first();

        Mail::to($data->request->endorser->email)->send(new EndorsementRequestEmail($data));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
