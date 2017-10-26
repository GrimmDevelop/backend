<?php

namespace App\Analyzer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface Analyzer
{

    /**
     * Adds search requirements to given builder
     *
     * @param Builder $builder
     */
    public function search(Builder $builder);

    /**
     * Returns a analyze message for given model if it
     * contains related data or null otherwise.
     *
     * @param Model $model
     * @return string|null
     */
    public function result(Model $model);
}