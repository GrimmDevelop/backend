<?php

namespace App\Grid;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Trait Gridable
 * @package Grimm
 *
 * @method Grid grid()
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