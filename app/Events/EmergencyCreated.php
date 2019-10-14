<?php

namespace App\Events;

use App\Emergency;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmergencyCreated implements ShouldBroadcast
{
    use SerializesModels;

    public $emergency;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Emergency $emergency)
    {
        $this->emergency = $emergency;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()

    {
        $userID = \DB::table('patient_assign')->where('patient_id', $this->emergency->patient_id)->first();

        return new Channel('user.'.$userID->user_id);
    }


    public function broadcastAs()
    {
        return 'emergency.created';
    }

    public function broadcastWith(){
        return [
                'emergency' => $this->emergency,
                'patient' => \DB::table('patients')->where('id', $this->emergency->patient_id)->first()
            ];
    }
}
