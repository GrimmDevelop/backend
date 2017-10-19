<?php

namespace App\Filters\Library;

use App\Filters\BooleanFilter;
use Illuminate\Database\Eloquent\Builder;

class DeneckeFilter extends BooleanFilter
{

    public function appliesTo()
    {
        return 'denecke';
    }

    protected function filterQuery(Builder $query)
    {
        $query->whereRaw('denecke_teitge = title');
    }

    public function displayString()
    {
        return 'filters.denecke';
    }
}