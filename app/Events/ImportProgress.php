<?php

namespace App\Events;

use Grimm\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ImportProgress implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $amount;
    private $total;
    private $type;
    /**
     * @var User
     */
    private $user;

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'event-queue';

    /**
     * Create a new event instance.
     *
     * @param $amount
     * @param $total
     * @param $type
     * @param User $user
     */
    public function __construct($amount, $total, $type, User $user)
    {
        $this->amount = $amount;
        $this->total = $total;
        $this->type = $type;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('import.user.' . $this->user->id);
    }

    public function broadcastWith()
    {
        return [
            'amount' => $this->amount,
            'total' => $this->total,
            'type' => $this->type
        ];
    }
}
