<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PollCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $uuid;
    public $poll;

    public function __construct($uuid, $poll)
    {
        $this->uuid = $uuid;
        $this->poll = $poll;
    }

    public function broadcastOn()
    {
        \Log::info('PollCreated::broadcastOn called', [
            'channel' => 'polls.'.$this->uuid
        ]);
        return new Channel('polls.'.$this->uuid);
    }

    public function broadcastAs()
    {
        \Log::info('PollCreated::broadcastAs called', [
            'event_name' => 'poll.created'
        ]);
        return 'poll.created';
    }

    public function broadcastWith()
    {
        \Log::info('PollCreated::broadcastWith called', [
            'uuid' => $this->uuid,
            'poll_data_keys' => is_array($this->poll) ? array_keys($this->poll) : 'not an array'
        ]);

        return [
            'uuid' => $this->uuid,
            'poll_data' => $this->poll,
            'timestamp' => now()->toIso8601String(),
            'message' => 'Poll created successfully'
        ];
    }
}
