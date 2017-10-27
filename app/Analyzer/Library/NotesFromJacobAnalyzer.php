<?php

namespace App\Analyzer\Library;

use App\Analyzer\Analyzer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NotesFromJacobAnalyzer implements Analyzer
{

    /**
     * Adds search requirements to given builder
     *
     * @param Builder $builder
     */
    public function search(Builder $builder)
    {
        $builder->where('denecke_teitge', 'regexp', '.*(J\.[\*]+).*')
            ->where(function (Builder $b) {
                $b->where('notes_jg', null)
                    ->orWhere('notes_jg', '');
            });
    }

    /**
     * Returns a analyze message for given model if it
     * contains related data or null otherwise.
     *
     * @param Model $model
     * @return string|null
     */
    public function result(Model $model)
    {
        if (preg_match('/.*(J\.[\*]+).*/', $model->denecke_teitge)) {
            return "Model contains a note from Jacob Grimm";
        }

        return null;
    }
}