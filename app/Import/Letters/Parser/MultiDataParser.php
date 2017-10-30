<?php

namespace App\Import\Letters\Parser;


use Grimm\Letter;
use App\Import\Parser\FieldParser;

class MultiDataParser implements FieldParser
{

    /**
     * @param $column
     * @param $field
     * @param Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        switch ($column) {
            case "datum":
                $letter->date = $field;
                break;
            case "sprache":
                $this->setLanguage($field, $letter);
                break;
            case "hs":
                $letter->handwriting_location = $field;
                break;
            case "inc":
                $letter->inc = $field;
                break;
            case "copy":
                $letter->copy = $field;
                break;
            case "couvert":
                $letter->couvert = $field;
                break;
            case "beilage":
                $letter->attachment = $field;
                break;
            case "verz_in":
                $letter->directory = $field;
                break;
            case "erschl_aus":
                $letter->reconstructed_from = $field;
                break;
            case "empf_verm":
                $letter->receive_annotation = $field;
                break;
            case "antw_verm":
                $letter->reply_annotation = $field;
                break;
        }

        $letter->save();
    }

    private function setLanguage($field, Letter $letter)
    {
        $lang = (empty($field)) ? 'de' : $field;

        $letter->language = $lang;
    }

    public function handledColumns()
    {
        return [
            'datum',
            'sprache',
            'hs',
            'inc',
            'copy',
            'couvert',
            'beilage',
            'verz_in',
            'erschl_aus',
            'empf_verm',
            'antw_verm'
        ];
    }
}