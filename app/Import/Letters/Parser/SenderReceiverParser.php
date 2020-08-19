<?php

namespace App\Import\Letters\Parser;


use Grimm\Letter;
use Grimm\LetterPersonAssociation;
use App\Import\Parser\FieldParser;
use Grimm\Person;
use Illuminate\Support\Collection;

class SenderReceiverParser implements FieldParser
{

    protected $personCache = [];


    /**
     * @param $column
     * @param $field
     * @param Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        $persons = $this->prepareField($field);

        foreach ($persons as $person) {
            if ($column == 'absender') {
                $assoc = new LetterPersonAssociation();

                $assoc->assignment_source = $person;
                $assoc->makePersonSender();
                $assoc->letter()->associate($letter);

                if ($relatedPerson = $this->lookUpPerson($person)) {
                    $assoc->person()->associate($relatedPerson);
                }

                $assoc->save();
            } else {
                if ($column == 'empfaenger') {
                    $assoc = new LetterPersonAssociation();

                    $assoc->assignment_source = $person;
                    $assoc->makePersonReceiver();
                    $assoc->letter()->associate($letter);

                    if ($relatedPerson = $this->lookUpPerson($person)) {
                        $assoc->person()->associate($relatedPerson);
                    }

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

        return collect(explode(';', $string))
            ->map(function ($item) {
                return trim($item);
            })->filter();
    }

    private function lookUpPerson($person)
    {
        if (!isset($this->personCache[$person])) {
            $data = explode(', ', $person);

            $lastName = $data[0] ?? null;
            $firstName = $data[1] ?? null;

            if ($lastName !== null && $firstName !== null) {
                $this->personCache[$person] = Person::query()
                    ->where('last_name', $lastName)
                    ->where('first_name', $firstName)
                    ->first();
            } else {
                $this->personCache[$person] = null;
            }
        }

        return $this->personCache[$person];
    }
}