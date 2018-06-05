<?php

namespace App\Import\Letters\Parser;


use Grimm\Letter;
use Grimm\Location;
use App\Import\Parser\FieldParser;

class FromToParser implements FieldParser
{

    /**
     * @param $column
     * @param $field
     * @param Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        switch ($column) {
            case "absendeort":
                $letter->from_location_historical = $field;
                break;
            case "absort_ers":
                $letter->from_location_derived = $field;
                break;
            case "empf_ort":
                $letter->to_location_historical = $field;
                break;
        }

        $letter->save();
    }

    public function handledColumns()
    {
        return ['absendeort', 'absort_ers', 'empf_ort'];
    }
}