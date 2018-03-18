<?php

namespace App\Filters\Letters;

use App\Filters\Filter;
use App\Filters\FilterWithOptionals;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CorrespondenceFilter implements FilterWithOptionals
{

    public function appliesTo()
    {
        return 'correspondence';
    }

    public function apply(Builder $query, Collection $values)
    {
        $query->byPerson($values->get($this->appliesTo()), $values->get('correspondence_type'));
    }

    public function shouldPreserve()
    {
        return true;
    }

    public function optionals()
    {
        return ['correspondence_type'];
    }
}