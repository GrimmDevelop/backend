<?php

namespace App\Events;

use Grimm\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ImportDone implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    private $user;

    private $letters;
    private $people;
    private $books;

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'event-queue';

    /**
     * Create a new event instance.
     *
     * @param $letters
     * @param $people
     * @param $books
     * @param User $user
     */
    public function __construct($letters, $people, $books, User $user)
    {
        $this->user = $user;
        $this->letters = $letters;
        $this->people = $people;
        $this->books = $books;
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
            'letters' => $this->letters,
            'people' => $this->people,
            'books' => $this->books
        ];
    }
}
