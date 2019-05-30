<?php

namespace App\Grid;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|static search($term)
 */
interface IsGridable
{

    /**
     * @return Grid
     */
    public function grid(): Grid;

    /**
     * @param bool $alsoHiddenOnes
     * @return \Illuminate\Support\Collection
     */
    public static function gridColumns($alsoHiddenOnes = false);


    /**
     * Gridifies a single column
     *
     * @param Column $column
     * @return mixed
     */
    public function gridify(Column $column);


    /**
     * @return \Illuminate\Support\Collection
     */
    public function activeGridRow();
}