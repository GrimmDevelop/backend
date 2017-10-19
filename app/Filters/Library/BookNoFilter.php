<?php

namespace App\Filters\Library;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class BookNoFilter implements Filter
{

    public function appliesTo()
    {
        return 'cat_id';
    }

    public function apply(Builder $query, Collection $values)
    {
        return $query->searchByCatalogId($values->get('cat_id'));
    }

    public function shouldPreserve()
    {
        return true;
    }
}