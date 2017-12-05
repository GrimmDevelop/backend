<?php

namespace App\Grid;

use Illuminate\Support\Collection;

class Grid
{

    private $namespace;
    protected $columns;

    public function __construct($namespace, array $columns = [])
    {
        $this->namespace = $namespace;

        $this->columns = collect();

        foreach ($columns as $column) {
            $this->add($column);
        }
    }

    /**
     * change visible state of columns by request data
     *
     * @return void
     */
    public function apply()
    {
        if ($columnName = request()->get('grid')) {
            $state = request()->get('state');

            if ($this->column($columnName)->isActive() != $state) {
                $this->toggleColumn($columnName);
            }
        }
    }

    /**
     * @param Column $column
     * @return $this
     */
    public function add(Column $column)
    {
        $this->columns[$column->name()] = $column;

        $column->setGrid($this);

        return $this;
    }

    /**
     * @param $name
     * @return Column
     */
    public function column($name)
    {
        return $this->columns[$name];
    }

    /**
     * @param bool $alsoHiddenOnes
     * @return Collection
     */
    public function columns($alsoHiddenOnes = false)
    {
        return $this->columns
            ->filter(function (Column $column) use ($alsoHiddenOnes) {
                if ($alsoHiddenOnes) {
                    return true;
                }

                return $column->isActive();
            });
    }

    /**
     * @param $items
     * @return Collection
     */
    public function data($items)
    {
        return collect($items)->map(function (IsGridable $model) {
            return $model->activeGridRow();
        });
    }

    /**
     * @param $name
     */
    public function toggleColumn($name)
    {
        $this->column($name)->toggle();
    }

    /**
     * @return string
     */
    public function namespace()
    {
        return $this->namespace . '.';
    }

    /**
     * returns the full session key (e.g. 'grid.letters.' ending with a dot
     * so you can use it directly with a column name
     *
     * @return string
     */
    public function gridSessionKey()
    {
        $namespace = 'grid.';

        return $namespace . $this->namespace();
    }
}