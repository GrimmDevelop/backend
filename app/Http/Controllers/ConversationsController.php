<?php

namespace App\Http\Controllers;

use Grimm\Letter;
use Illuminate\Http\Request;

class ConversationsController extends Controller
{

    public function show(Letter $letter)
    {
        $sender = $letter->senders()[0];
        $receiver = $letter->receivers()[0];

        $nextLetter = Letter::query()
            ->with('personAssociations')
            ->whereHas('personAssociations', function ($builder) use ($sender, $receiver) {
                $builder->where('assignment_source', $receiver->assignment_source)
                    ->where('type', 0);
            })
            ->whereHas('personAssociations', function ($builder) use ($sender, $receiver) {
                $builder->where('assignment_source', $sender->assignment_source)
                    ->where('type', 1);
            })
            ->where('code', '>', $letter->code)
            ->orderBy('code')
            ->first();

        dump($letter->senders()->pluck('assignment_source'));
        dump($letter->receivers()->pluck('assignment_source'));
        dump($nextLetter->senders()->pluck('assignment_source'));
        dump($nextLetter->receivers()->pluck('assignment_source'));
        dump($nextLetter);
    }
}
