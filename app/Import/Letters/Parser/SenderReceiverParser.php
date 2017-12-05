<?php

namespace App\Import\Letters\Parser;


use Grimm\Letter;
use Grimm\LetterPersonAssociation;
use App\Import\Parser\FieldParser;
use Illuminate\Support\Collection;

class SenderReceiverParser implements FieldParser
{


    /**
     * @param $column
     * @param $field
     * @param Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        $persons = $this->prepareField($field);

        foreach($persons as $person) {
            if ($column == 'absender') {
                $assoc = new LetterPersonAssociation();

                $assoc->assignment_source = $person;
                $assoc->makePersonSender();
                $assoc->letter()->associate($letter);

                $assoc->save();
            } else {
                if ($column == 'empfaenger') {
                    $assoc = new LetterPersonAssociation();

                    $assoc->assignment_source = $person;
                    $assoc->makePersonReceiver();
                    $assoc->letter()->associate($letter);

                    $assoc->save();
                }
            }
        }
    }

    public function handledColumns()
    {
        return ['absender', 'empfaenger'];
    }

    /**
     * @param $string
     * @return Collection
     */
    private function prepareField($string)
    {
        $string = preg_replace("/;([\\/~><])/", ":$1", $string);

        $persons = collect(explode(';', $string))
            ->map(function ($item) {
                return trim($item);
            })->filter();

        return $persons;
    }
}