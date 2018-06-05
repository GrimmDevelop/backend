<?php

namespace App\Import\Letters\Parser;

use App\Import\Parser\FieldParser;
use Grimm\LetterTranscription;

class TranscriptionParser implements FieldParser
{

    use YearParser, OrderExtractor;

    /**
     * @param $column
     * @param $field
     * @param \Grimm\Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        $transcription = new LetterTranscription();

        $transcription->entry = $field;
        $transcription->year = $this->parseYear($field);
        $transcription->sort = $this->extractOrder($column);

        $transcription->letter()->associate($letter);

        $transcription->save();
    }

    public function handledColumns()
    {
        return [
            'abschrift',
            'abschr_2',
            'abschr_3',
            'abschr_4'
        ];
    }
}