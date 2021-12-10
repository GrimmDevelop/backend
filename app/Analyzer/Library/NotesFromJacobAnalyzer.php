<?php

namespace App\Analyzer\Library;

use App\Analyzer\Analyzer;
use App\Analyzer\RegexpAnalyzer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NotesFromJacobAnalyzer extends RegexpAnalyzer
{

    /**
     * the actual regular expression which searches inside the database
     *
     * @return string
     */
    protected function regexp(): string
    {
        return '.*(?<notes_jg>J\.[\*]+).*';
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
        return ['notes_jg'];
    }

    /**
     * The messages displayed if something was found by the regular expression
     *
     * @return string
     */
    protected function displayString(): string
    {
        return "Denecke field contains a note from Jacob Grimm [%s] but corresponding field is empty.";
    }
}