<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotificationSending implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $userTypeId;

    public function __construct($message, $userTypeId)
    {
        $this->message = $message;
        $this->userTypeId = $userTypeId;
        Log::info('NotificationSending event triggered', ['message' => $message, 'userTypeId' => $userTypeId]);
    }

    public function broadcastOn()
    {
        return new Channel('user-type-' . $this->userTypeId);
    }

    public function broadcastWith()
    {
        return ['message' => $this->message];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
