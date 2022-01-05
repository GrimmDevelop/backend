<?php

namespace App\Analyzer\Library;

use App\Analyzer\RegexpAnalyzer;

class PurchaseNumberAnalyzer extends RegexpAnalyzer
{

    /**
     * the actual regular expression which searches inside the database
     *
     * @return string
     */
    protected function regexp(): string
    {
        return '.*(?<purchase_number>[0-9]{2}\.[0-9]{3}).*';
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
            'purchase_number',
        ];
    }

    /**
     * The messages displayed if something was found by the regular expression
     *
     * @return string
     */
    protected function displayString(): string
    {
        return "Denecke field contains possible purchase number [%s] but corresponding field is empty.";
    }
}