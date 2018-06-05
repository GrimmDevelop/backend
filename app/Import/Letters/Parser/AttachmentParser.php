<?php

namespace App\Import\Letters\Parser;

use App\Import\Parser\FieldParser;
use Grimm\LetterAttachment;

class AttachmentParser implements FieldParser
{

    /**
     * @param $column
     * @param $field
     * @param \Grimm\Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        $draft = new LetterAttachment();
        $draft->entry = $field;
        $draft->letter()->associate($letter);

        $draft->save();
    }

    public function handledColumns()
    {
        return [
            'beilage',
        ];
    }
}