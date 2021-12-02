<?php

namespace App\Http\Controllers\Data\People;

use Grimm\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeopleController
{

    public function index()
    {
        return Person::searchByName(request('name'))->paginate(20);
    }

    public function get()
    {
        $people = DB::table('letter_person')
            ->select('assignment_source')
            ->distinct()
            ->where('assignment_source','like', '%' . request('name') . '%')
            ->get();

        return $people;
    }
}
