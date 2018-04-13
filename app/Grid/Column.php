<?php

namespace App\Grid;

use Illuminate\Database\Eloquent\Model;

class Column
{

    private $name;
    private $defaultState;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @var  Grid
     */
    protected $grid;

    public function __construct($name, $defaultState, callable $callback = null)
    {
        $this->name = $name;
        $this->defaultState = $defaultState;
        $this->callback = $callback;
    }

    public function getGrid()
    {
        return $this->grid;
    }

    public function setGrid(Grid $grid)
    {
        $this->grid = $grid;

        return $this;
    }

    public function name()
    {
        return $this->name;
    }

    public function isActive()
    {
        $key = $this->grid->gridSessionKey() . $this->name();

        return session($key, $this->defaultState);
    }

    public function value(Model $model)
    {
        $callback = $this->callback;

        if ($callback === null) {
            return $model->{$this->name};
        }

        return $callback($model);
    }

    public function toggle()
    {
        $key = $this->grid->gridSessionKey() . $this->name();

        $newState = !$this->isActive();

        session()->put($key, $newState);

        return $this;
    }
}