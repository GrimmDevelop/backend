<?php

namespace App\Http\Controllers\Data\People;

use Grimm\Person;
use Illuminate\Http\Request;

class PeopleController
{
    /**
     * JSON based search via person names
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function search(Request $request)
    {
        // catch both: sender and receiver, how?
        $query = Person::searchByName($request->get('name'));

        /*
         * Sort by full text match
        $query->orderBy('last_name')
        ->orderBy('first_name');
        */

        return $query->paginate(20);
    }
}
