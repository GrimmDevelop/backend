<?php

namespace App\Filters\Shared;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SearchFilter implements Filter
{

    public function appliesTo()
    {
        return 'search';
    }

    public function apply(Builder $query, Collection $values)
    {
        if ($query instanceof \Sofa\Eloquence\Builder) {
            $query->search($values->get('search'));
        }
    }

    public function shouldPreserve()
    {
        return true;
    }
}