<?php

namespace App\Filters\Library;

use App\Filters\BooleanFilter;
use Illuminate\Database\Eloquent\Builder;

class FolkFilter extends BooleanFilter
{

    /**
     * @return string
     */
    public function appliesTo()
    {
        return 'folk';
    }

    /**
     * Runs the query if filter is active
     *
     * @param Builder $query
     * @return Builder
     */
    protected function filterQuery(Builder $query)
    {
        return $query->whereNotNull('tales_comm_1856')
            ->where('tales_comm_1856', '<>', ' ');
    }

    public function displayString()
    {
        return 'filters.folk';
    }
}