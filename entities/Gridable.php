<?php

namespace Grimm;

use App\Grid\Column;
use App\Grid\Grid;

/**
 * Trait Gridable
 * @package Grimm
 *
 * @method \App\Grid\Grid grid()
 */
trait Gridable
{

    public static function applyGrid()
    {
        if ($columnName = request()->get('grid')) {
            /** @var Grid $grid */
            $grid = (new static)->grid();

            $state = request()->get('state');

            if ($grid->column($columnName)->isActive() != $state) {
                $grid->toggleColumn($columnName);
            }
        }
    }

    public static function staticGridColumns($alsoHiddenOnes = false)
    {
        return (new static())->gridColumns($alsoHiddenOnes);
    }

    public function gridColumns($alsoHiddenOnes = false)
    {
        return $this->grid()
            ->columns()
            ->filter(function (Column $column) use ($alsoHiddenOnes) {
                if ($alsoHiddenOnes) {
                    return true;
                }

                return $column->isActive();
            });
    }

    public function gridify(Column $column)
    {
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = $this;

        return $column->value($model);
    }
}