<?php

namespace App\Analyzer\Library;

use App\Analyzer\Analyzer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NotesFromWilhelmAnalyzer implements Analyzer
{

    /**
     * Adds search requirements to given builder
     *
     * @param Builder $builder
     */
    public function search(Builder $builder)
    {
        $builder->where('denecke_teitge', 'regexp', '.*(W\.[\*]+).*')
            ->where(function (Builder $b) {
                $b->where('notes_wg', null)
                    ->orWhere('notes_wg', '');
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
        if (preg_match('/.*(W\.[\*]+).*/', $model->denecke_teitge)) {
            return "Model contains a note from Wilhelm Grimm";
        }

        return null;
    }
}