<?php

namespace App\Import\Letters\Parser;

trait OrderExtractor
{

    protected function extractOrder($field)
    {
        // dr_1 => 0, dr_2 => 1

        $components = explode('_', $field);

        return intval($components[1] ?? 1) - 1;
    }

}