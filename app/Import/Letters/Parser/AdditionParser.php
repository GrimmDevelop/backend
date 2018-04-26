<?php

namespace App\Import\Letters\Parser;

use App\Import\Parser\FieldParser;

class AdditionParser implements FieldParser
{

    /**
     * @param $column
     * @param $field
     * @param \Grimm\Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        if ($column == 'zusatz' && $letter->addition != '') {
            $letter->addition = $field . ' ' . $letter->addition;
        } else {
            $letter->addition .= ' ' . $field;
        }

        $letter->addition = trim($letter->addition);

        $letter->save();
    }

    public function handledColumns()
    {
        return ['zusatz', 'zusatz_2'];
    }
}