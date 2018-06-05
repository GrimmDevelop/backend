<?php

namespace App\Import\Letters\Parser;


use Grimm\Letter;
use Grimm\LetterPrint;
use App\Import\Parser\FieldParser;

class PrintParser implements FieldParser
{

    use YearParser, OrderExtractor;

    /**
     * @param $column
     * @param $field
     * @param Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        // Hanauisches Magazin Bd. 14 (1935) S. 3-4


        $year = $this->parseYear($field);

        $print = new LetterPrint();

        $print->entry = $field;
        $print->year = $year;
        $print->sort = $this->extractOrder($column);

        $print->letter()->associate($letter);

        $print->save();
    }

    public function handledColumns()
    {
        return [
            'dr',
            'dr_1',
            'dr_2',
            'dr_3',
            'dr_4',
            'dr_5',
            'dr_6',
            'dr_7',
        ];
    }
}