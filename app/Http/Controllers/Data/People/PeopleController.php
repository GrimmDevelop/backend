<?php

namespace App\Http\Controllers\Data\People;

use Grimm\LetterPersonAssociation;
use Grimm\Person;

class PeopleController
{

    public function index()
    {
        return Person::searchByName(request('name'))->paginate(20);
    }

    public function get()
    {
        $people = LetterPersonAssociation::query()
            ->search(request('name'))
            ->limit(100)
            ->get();

        return fractal()->collection($people, function (LetterPersonAssociation $association) {
            return [
                'assignment_source' => $association->assignment_source,
                'person_id' => $association->person_id,
                'type' => $association->type,
            ];
        });
    }
}
