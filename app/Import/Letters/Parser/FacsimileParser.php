<?php

namespace App\Import\Letters\Parser;

use Grimm\Facsimile;
use Grimm\Letter;
use App\Import\Parser\FieldParser;

class FacsimileParser implements FieldParser
{

    use YearParser;

    /**
     * @param $column
     * @param $field
     * @param Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        $year = $this->parseYear($field);

        $facs = new Facsimile();

        $facs->entry = $field;
        $facs->year = $year;
        $facs->letter()->associate($letter);

        $facs->save();
    }

    public function handledColumns()
    {
        return ['faks'];
    }
}