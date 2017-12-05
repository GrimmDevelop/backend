<?php

namespace App\Filters\Shared;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PageSizeFilter implements Filter
{

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var int
     */
    private $defaultPageSize;

    /**
     * @var array
     */
    private $pageSizes = [10, 20, 50, 100];

    public function __construct($namespace, $defaultPageSize = 20, $pageSizes = null)
    {
        $this->namespace = $namespace;
        $this->defaultPageSize = $defaultPageSize;

        if ($pageSizes !== null) {
            $this->pageSizes = $pageSizes;
        }
    }

    public function appliesTo()
    {
        return 'page-size';
    }

    public function pageSize()
    {
        return session($this->sessionKey(), $this->defaultPageSize);
    }

    public function pageSizes()
    {
        return $this->pageSizes;
    }

    public function apply(Builder $query, Collection $values)
    {
        session()->put($this->sessionKey(), $values->get('page-size'));
    }

    public function shouldPreserve()
    {
        return false;
    }

    protected function sessionKey()
    {
        return $this->appliesTo() . '.' . $this->namespace;
    }
}