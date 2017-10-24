<?php

namespace App\Filters\Shared;

use App\Filters\BooleanFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Filter to only display trashed records,
 * whereas TrashFilter does add the trashed records to the
 * result set
 *
 * @package App\Filters\Shared
 */
class OnlyTrashedFilter extends BooleanFilter
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
        return 'only_trashed';
    }

    public function displayString()
    {
        return 'filters.only_trashed';
    }

    /**
     * Runs the query if filter is active
     *
     * @param Builder $query
     */
    protected function filterQuery(Builder $query)
    {
        $query->onlyTrashed();
    }

    protected function namespace()
    {
        return $this->namespace;
    }
}
