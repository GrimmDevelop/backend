<?php

namespace Grimm;

use App\Grid\Column;
use App\Grid\Grid;
use Illuminate\Support\Collection;

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

    public function activeGridRow()
    {
        $row = collect($this->gridColumns());
        return $row->map(function ($column) {
            return $this->gridify($column);
        });
    }

    /**
     * @param Collection $gridItems
     * @return mixed
     */
    public static function activeGridData($gridItems)
    {
        return $gridItems->map(function ($items) {
            return $items->activeGridRow();
        });
    }
}