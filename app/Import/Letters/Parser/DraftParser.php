<?php

namespace App\Import\Letters\Parser;

use Grimm\Draft;
use Grimm\Letter;
use App\Import\Parser\FieldParser;

class DraftParser implements FieldParser
{

    use YearParser;

    public function parse($column, $field, $letter)
    {
        $year = $this->parseYear($field);

        $draft = new Draft();
        $draft->entry = $field;
        $draft->year = $year;
        $draft->letter()->associate($letter);

        $draft->save();
    }

    public function handledColumns()
    {
        return ['konzept', 'konzept_2'];
    }
}