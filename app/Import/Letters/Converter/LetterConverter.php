<?php

namespace App\Import\Letters\Converter;

use App\Import\Converter\DBFRecordConverter;
use Grimm\Letter;
use XBase\Column;

class LetterConverter
{

    use DBFRecordConverter;

    /**
     * Returns a new letter entity
     *
     * @return Letter
     */
    public function setupEntity()
    {
        $letter = new Letter();
        // $letter->save();

        return $letter;
    }

    /**
     * @param array $columns
     * @return array
     */
    protected function setupColumns(array $columns)
    {
        // Fix to set id first and then all other fields
        usort($columns, function (Column $a, Column $b) {
            if ($a->getName() == 'nr') {
                return -1;
            }

            if ($b->getName() == 'nr') {
                return 1;
            }

            return 0;
        });

        return $columns;
    }
}