<?php

namespace App\Grid;

use Illuminate\Support\Collection;

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
     * @return Collection
     */
    public static function gridColumns($alsoHiddenOnes = false)
    {
        return static::gridStatic()
            ->columns($alsoHiddenOnes);
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