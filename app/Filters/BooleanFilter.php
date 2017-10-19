<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

abstract class BooleanFilter implements Filter, SelectableFilter
{


    /**
     * @return string
     */
    abstract public function appliesTo();

    /**
     * Runs the query if filter is active
     *
     * @param Builder $query
     */
    abstract protected function filterQuery(Builder $query);

    /**
     * returns the name of session key
     * use a unique name (like appliedTo() and a namespace or so)
     *
     * @return string
     */
    protected function sessionKey()
    {
        if (method_exists($this, 'namespace')) {
            return $this->namespace() . '.' . $this->appliesTo();
        }

        return $this->appliesTo();
    }

    public function apply(Builder $query, Collection $values)
    {
        if ($values->has($this->appliesTo())) {
            $key = $this->sessionKey();

            $to = $values->get($this->appliesTo());
            session([$key => $to]);
        }

        return $query;
    }

    public function default(Builder $query)
    {
        if ($this->applied()) {
            $this->filterQuery($query);
        }
    }

    public function shouldPreserve()
    {
        return false;
    }

    public function applied()
    {
        return session($this->sessionKey());
    }

    public function nextValue()
    {
        return !$this->applied();
    }
}