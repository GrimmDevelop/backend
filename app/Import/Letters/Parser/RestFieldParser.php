<?php

namespace App\Import\Letters\Parser;


use Grimm\Letter;
use Grimm\LetterCode;
use Grimm\LetterInformation;
use App\Import\Parser\FieldParser;

class RestFieldParser implements FieldParser
{

    protected $codes = [];

    /**
     * @param $column
     * @param $field
     * @param Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        if (!$letter->exists || $letter->id == 0) {
            \Log::error('letter id not set or letter does not exists!');

            return;
        }

        $columnName = ($column == 'zusatz_2') ? 'zusatz' : $column;

        $letterInfo = new LetterInformation();
        $letterInfo->data = $field;
        $letterInfo->letterCode()->associate($this->codes($columnName));
        $letterInfo->letter()->associate($letter);

        $letterInfo->save();
    }

    public function handledColumns()
    {
        return ['gesehen_12', 'zusatz', 'zusatz_2', 'ba', 'ausg_notiz', 'tb_nr', 'del'];
    }

    private function codes($code)
    {
        if (!isset($this->codes[$code])) {
            $letterCode = new LetterCode();
            $letterCode->name = $code;
            $letterCode->error_generated = true;
            $letterCode->internal = true;
            $letterCode->save();

            $this->codes[$code] = $letterCode;
        }

        return $this->codes[$code];
    }
}