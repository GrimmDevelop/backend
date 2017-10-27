<?php

namespace App\Analyzer\Library;

use App\Analyzer\Analyzer;
use App\Analyzer\RegexpAnalyzer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NotesFromWilhelmAnalyzer extends RegexpAnalyzer
{

    /**
     * The actual regular expression which searches inside the database.
     * All fields (from the method fields()) have to occur inside the expression as matching indices.
     * The delimiter is always "/" so any occurrence of "/" inside the expression has to be escaped.
     *
     * @return string
     */
    protected function regexp(): string
    {
        return '.*(?<notes_wg>W\.[\*]+).*';
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
        return ['notes_wg'];
    }

    /**
     * The messages displayed if something was found by the regular expression
     *
     * @return string
     */
    protected function displayString(): string
    {
        return "Model contains a note from Wilhelm Grimm [%s]";
    }
}