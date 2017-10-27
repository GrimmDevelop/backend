<?php

namespace App\Analyzer\Library;

use App\Analyzer\RegexpAnalyzer;

class PublishingDataAnalyzer extends RegexpAnalyzer
{

    /**
     * the actual regular expression which searches inside the database
     *
     * @return string
     */
    protected function regexp(): string
    {
        return '.*\s+(?<place>[\w]+)\:\s+(?<publisher>[\w]+)\s+(?<year>[0-9]{4}(?:(?:\-|—)[0-9]{4}){0,1})\.\s+.*';
    }

    /**
     * Field to search with regular expression
     *
     * @return string
     */
    protected function appliesTo(): string
    {
        return 'denecke_teitge';
    }

    /**
     * All field which are found by the regular expression
     *
     * @return array
     */
    protected function fields(): array
    {
        return [
            'place',
            'publisher',
            'year',
        ];
    }

    /**
     * The messages displayed if something was found by the regular expression
     *
     * @return string
     */
    protected function displayString(): string
    {
        return "Model contains possible publishing data [%s: %s %s].";
    }
}