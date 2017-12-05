<?php

namespace App\Import\Letters\Parser;


trait YearParser
{

    protected function parseYear($field)
    {
        $pattern = '/\((\d{4})\)/';

        $match = preg_match($pattern, $field, $matches);

        if ($match) {
            $year = intval($matches[1]);
        } else {
            $year = null;
        }

        return $year;
    }
}
