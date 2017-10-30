<?php

namespace App\Import\Letters\Parser;

use App\Import\Parser\FieldParser;

class CodeParser implements FieldParser
{

    /**
     * @param $column
     * @param $field
     * @param \Grimm\Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        $code = floatval(str_replace(',', '.', $field));
        $letter->code = sprintf("%.4f", $code);

        $letter->save();
    }

    public function handledColumns()
    {
        return ['code'];
    }
}