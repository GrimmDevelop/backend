<?php

namespace Tests\Unit;

use Grimm\Person;
use Illuminate\Support\Str;
use Tests\TestCase;

class PersonTest extends TestCase
{

    /**
     * @test
     */
    public function a_person_can_be_scoped_by_letters()
    {
        foreach (Person::byPrefix('a')->get() as $person) {
            $this->assertTrue(Str::startsWith(Str::lower($person->last_name), ['a', 'ä']));
        }
    }
}
