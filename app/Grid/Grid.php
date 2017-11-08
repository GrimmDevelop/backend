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
     * @return Collection
     */
    public function columns()
    {
        return $this->columns;
    }

    public function toggleColumn($name)
    {
        $this->column($name)->toggle();
    }

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