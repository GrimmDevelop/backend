<?php

namespace App\Grid;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @method Grid grid()
 * @method static \Illuminate\Database\Eloquent\Builder|static search($term, $field = null)
 */
trait Gridable
{

    /**
     * @return Grid
     */
    public static function gridStatic()
    {
        return (new static)->grid();
    }

    /**
     * short helper for readability
     *
     * @return void
     */
    public static function applyGrid()
    {
        static::gridStatic()->apply();
    }

    public function scopeSearch(Builder $query, $term, $field = null)
    {
        $table = $query->getModel()->getTable();

        /*$query->select($table . '.*');
        $query->groupBy("$table.{$this->getKeyName()}");*/

        $query->where(function () use ($field, $query, $table, $term) {
            foreach ($this->getSearchableColumns($field) as $column) {
                if ($column instanceof \Closure) {
                    $query->orWhere(function ($q) use ($column, $term) {
                        $column($q, $term);
                    });
                } elseif (Str::contains($column, '.')) {
                    [$relationName, $column] = explode('.', $column);

                    /** @var Relation $relation */
                    $relation = $this->{$relationName}();

                    if ($relation instanceof HasOneOrMany) {
                        $query->orWhereHas($relationName, function (Builder $query) use ($column, $term) {
                            $query->where($column, 'LIKE', "%$term%");
                        });
                        // $this->joinOneOrMany($query, $relation, $column, $term);
                    } else {
                        throw new \Exception("Search algorithm for relation {$relationName} not defined");
                    }
                } else {
                    // $query->orWhereRaw("match($column) against (? in boolean mode)", [$term]);
                    $query->orWhere("{$table}.{$column}", 'LIKE', "%$term%");
                }
            }
        });
    }

    /**
     * @return Collection|string[]
     */
    protected function getSearchableColumns($field)
    {
        return $this->grid()->columns()->filter(function(Column $column) use ($field) {
            return $field === null || $column->name() === $field;
        })->map(function (Column $column) {
            return $column->searchKey();
        })->values()->unique();
    }

    protected function joinOneOrMany(Builder $query, Relation $relation, string $column, string $term)
    {
        $relationTable = uniqid('join_');

        $query->leftJoin($relation->getModel()->getTable() . ' as ' . $relationTable,
            function (JoinClause $join) use ($relationTable, $term, $relation) {
                $join->on(
                    $relation->getQualifiedParentKeyName(),
                    '=',
                    $relationTable . '.' . $relation->getForeignKeyName()
                );
            })
            ->orWhere($relationTable . '.' . $column, 'LIKE', "%$term%");
    }

    /**
     * Helper method for blade files
     *
     * @param bool $alsoHiddenOnes
     * @param bool $sort
     * @return Collection
     */
    public static function gridColumns($alsoHiddenOnes = false, $sort = false)
    {
        $columns = static::gridStatic()
            ->columns($alsoHiddenOnes);

        if ($sort) {
            $columns = $columns->sort(function (Column $columnA, Column $columnB) {
                return strcmp(trans('letters.' . $columnA->name()), trans('letters.' . $columnB->name()));
            });
        }

        return $columns;
    }

    public static function translatedColumns($alsoHiddenOnes = false)
    {
        return static::gridColumns($alsoHiddenOnes)->map(function (Column $column) {
            return trans($column->getGrid()->namespace() . $column->name());
        });
    }

    /**
     * @inheritdoc
     */
    public function gridify(Column $column)
    {
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = $this;

        return $column->value($model);
    }

    /**
     * @return Collection
     */
    public function activeGridRow()
    {
        return $this->grid()
            ->columns()
            ->map(function ($column) {
                return $this->gridify($column);
            });
    }

    /**
     * @param mixed $items
     * @return mixed
     */
    public static function activeGridData($items)
    {
        return (new static)->grid()->data($items);
    }
}