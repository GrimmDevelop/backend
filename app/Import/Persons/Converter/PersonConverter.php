<?php

namespace App\Import\Persons\Converter;


use App\Import\Converter\DBFRecordConverter;
use App\Import\ModelConverter;
use Grimm\Person;

class PersonConverter implements ModelConverter
{

    use DBFRecordConverter;

    public function setupEntity()
    {
        $p = new Person();
        $p->save();

        return $p;
    }

    /**
     * Returns model type which is converted
     *
     * @return string
     */
    public function type()
    {
        return Person::class;
    }
}