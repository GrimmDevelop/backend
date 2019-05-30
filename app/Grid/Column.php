<?php

namespace App\Grid;

use Illuminate\Database\Eloquent\Model;

class Column
{

    /**
     * name of grid column
     *
     * @var string
     */
    private $name;

    /**
     * default visibility state of grid column
     *
     * @var bool
     */
    private $defaultState;

    /**
     * @var callable
     */
    private $callback;

    /**
     * key used by grid search
     *
     * @var string
     */
    private $searchKey;

    /**
     * @var  Grid
     */
    protected $grid;

    public function __construct($name, $defaultState, callable $callback = null, $searchKey = null)
    {
        $this->name = $name;
        $this->defaultState = $defaultState;
        $this->callback = $callback;
        $this->searchKey = $searchKey ?? $this->name();
    }

    /**
     * @return string
     */
    public function searchKey()
    {
        return $this->searchKey;
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

    /**
     * returns the name of the column
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Returns true if the user has activated the column
     * If the user hasn't changed the state, the default state is used
     *
     * @return bool
     */
    public function isActive()
    {
        $key = $this->grid->gridSessionKey() . $this->name();

        return session($key, $this->defaultState);
    }

    /**
     * Returns either the value of a model field
     * or the return value of given callback
     *
     * @param Model $model
     * @return mixed
     */
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