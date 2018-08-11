<?php

namespace App\Import\Letters\Parser;

use Grimm\Letter;
use App\Import\Parser\FieldParser;

class IdParser implements FieldParser
{

    /**
     * @param $column
     * @param $field
     * @param Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        switch ($column) {
            case 'nr_2018':
                $letter->id_till_2018 = (int)$field;
                break;
            case 'nr_1992':
                $letter->id_till_1992 = (int)$field;
                break;
            case 'nr_1997':
                $letter->id_till_1997 = (int)$field;
                break;
        }

        $letter->save();
    }

    public function handledColumns()
    {
        return ['nr_2018', 'nr_1992', 'nr_1997'];
    }
}