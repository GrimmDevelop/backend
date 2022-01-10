<?php

namespace Grimm\Transformers;

use Grimm\LetterPrint;
use League\Fractal\TransformerAbstract;


class LetterPrintTransformer extends TransformerAbstract
{


    public function transform(LetterPrint $print)
    {
        return [
            'entry' => $print->entry,
            'year' => $print->year,
            'transcription' => $print->transcription,
            'sort' => $print->sort
        ];
    }
}