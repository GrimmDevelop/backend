<?php

namespace App\Filters\Shared;

use App\Filters\Filter;
use App\Filters\FlagFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Include trashed records into result set
 *
 * @package App\Filters\Shared
 */
class TrashFilter implements Filter, FlagFilter
{

    /**
     * @var
     */
    private $namespace;

    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    public function appliesTo()
    {
        return 'trash';
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
        if (session($this->sessionKey()) == 1) {
            $query->withTrashed();
        } else if (session($this->sessionKey()) == 2) {
            $query->onlyTrashed();
        }
    }

    protected function sessionKey()
    {
        return $this->namespace . '.trash';
    }

    public function shouldPreserve()
    {
        return false;
    }

    public function nextValue()
    {
        return (session($this->sessionKey()) + 1) % 3;
    }

    public function applied()
    {
        return session($this->sessionKey()) > 0;
    }

    public function value()
    {
        return session($this->sessionKey());
    }
}
