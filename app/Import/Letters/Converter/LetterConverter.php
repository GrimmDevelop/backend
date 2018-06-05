<?php

namespace App\Import\Letters\Converter;

use App\Import\Converter\DBFRecordConverter;
use App\Import\ModelConverter;
use App\Transformers\UniqueIdTransformer;
use Grimm\Letter;
use XBase\Column;

class LetterConverter implements ModelConverter
{

    use DBFRecordConverter;

    /**
     * Returns a new letter entity
     *
     * @return Letter
     */
    public function setupEntity()
    {
        $transformer = new UniqueIdTransformer();

        $letter = new Letter();
        $letter->save();

        $letter->unique_code = $transformer->transform($letter->id);

        return $letter;
    }

    /**
     * Returns model type which is converted
     *
     * @return string
     */
    public function type()
    {
        return Letter::class;
    }
}