<?php

namespace App\Events;

use App\Events\Event;
use Grimm\LibraryBook;
use Grimm\User;
use Illuminate\Queue\SerializesModels;

class DestroyLibraryRelationEvent extends Event
{

    use SerializesModels;

    /**
     * @var LibraryBook
     */
    public $book;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param LibraryBook $book
     * @param User $user
     */
    public function __construct(LibraryBook $book, User $user)
    {
        $this->book = $book;
        $this->user = $user;
    }
}
