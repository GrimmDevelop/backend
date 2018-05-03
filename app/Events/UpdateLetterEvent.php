<?php

namespace App\Events;

use Grimm\Letter;
use Grimm\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UpdateLetterEvent
{

    use Dispatchable, SerializesModels;
    /**
     * @var Letter
     */
    private $letter;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new event instance.
     *
     * @param Letter $letter
     * @param User $user
     */
    public function __construct(Letter $letter, User $user)
    {
        $this->letter = $letter;
        $this->user = $user;
    }
}
