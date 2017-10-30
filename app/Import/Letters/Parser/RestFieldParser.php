<?php

namespace App\Import\Letters\Parser;


use Grimm\Letter;
use Grimm\LetterCode;
use Grimm\LetterInformation;
use App\Import\Parser\FieldParser;

class RestFieldParser implements FieldParser
{

    protected $codes = [];

    public function __construct()
    {
        $this->populateCodes();
    }

    public function parse($column, $field, $letter)
    {
        $columnName = ($column == 'zusatz_2') ? 'zusatz' : $column;

        $letterInfo = new LetterInformation();
        $letterInfo->data = $field;
        $letterInfo->letterCode()->associate($this->codes[$columnName]);
        $letterInfo->letter()->associate($letter);

        $letterInfo->save();
    }

    public function handledColumns()
    {
        return ['gesehen_12', 'zusatz', 'zusatz_2', 'ba', 'ausg_notiz', 'tb_nr', 'del'];
    }

    private function populateCodes()
    {
        foreach ($this->handledColumns() as $code) {
            if ($code != 'zusatz_2') {
                // TODO: search for code, if already in database
                $letterCode = new LetterCode();
                $letterCode->name = $code;
                $letterCode->error_generated = true;
                $letterCode->internal = true;
                $letterCode->save();

                $this->codes[$code] = $letterCode;
            }
        }
    }
}