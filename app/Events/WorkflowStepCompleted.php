<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class WorkflowStepCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $oldStep;
    public $nextStep;
    public $exec;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($exec, $oldStep, $nextStep)
    {
        $this->exec = $exec;
        $this->oldStep = $oldStep;
        $this->nextStep = $nextStep;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    /*public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }*/
}
