<?php

namespace App\Import\Letters\Parser;


use Grimm\AuctionCatalogue;
use Grimm\Letter;
use App\Import\Parser\FieldParser;

class AuktkatParser implements FieldParser {

    use YearParser;

    /**
     * TODO: in fact it is in many cases possible to extract much more data
     * @param $column
     * @param $field
     * @param Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        // $pattern = '/^([^,\d]+)(\d*)?(?:.+(?:\((\d{4})\)))?/';

        $year = $this->parseYear($field);

        $cat = new AuctionCatalogue();

        $cat->entry = $field;
        $cat->year = $year;

        $cat->letter()->associate($letter);

        $cat->save();
    }

    public function handledColumns()
    {
        return ['auktkat', 'auktkat_2', 'auktkat_3', 'auktkat_4'];
    }
}