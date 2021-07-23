<?php

namespace App\Filters\Shared;

use App\Filters\FilterWithOptionals;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SearchFilter implements FilterWithOptionals
{

    public function appliesTo()
    {
        return 'search';
    }

    public function apply(Builder $query, Collection $values)
    {
        $query->search($values->get('search'), $values->get('field'));
    }

    public function shouldPreserve()
    {
        return true;
    }

    public function optionals()
    {
        return ['field'];
    }
}