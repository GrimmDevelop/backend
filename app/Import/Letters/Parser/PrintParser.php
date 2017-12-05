<?php

namespace App\Import\Letters\Parser;


use Grimm\Letter;
use Grimm\LetterPrint;
use App\Import\Parser\FieldParser;

class PrintParser implements FieldParser
{

    use YearParser;

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

        if ($column == 'abschrift') {
            $order = 0;
        } else {
            $order = $this->extractOrder($column);
        }

        if ($column[0] === 'a') {
            $print->transcription = true;
        }

        $print->entry = $field;
        $print->year = $year;
        $print->sort = $order;

        $print->letter()->associate($letter);

        $print->save();
    }

    private function extractOrder($field)
    {
        // dr_1 => 0, dr_2 => 1

        $components = explode('_', $field);

        return intval(array_pop($components)) - 1;
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
            'abschrift',
            'abschr_2',
            'abschr_3',
            'abschr_4'
        ];
    }
}