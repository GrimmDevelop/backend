<?php

namespace App\Analyzer\Library;

use App\Analyzer\Analyzer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PurchaseNumberAnalyzer implements Analyzer
{

    /**
     * Adds search requirements to given builder
     *
     * @param Builder $builder
     */
    public function search(Builder $builder)
    {
        $builder->where('denecke_teitge', 'regexp', '.*[0-9]{2}\.[0-9]{3}.*')
            ->where(function (Builder $b) {
                $b->where('purchase_number', null)
                    ->orWhere('purchase_number', '');
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
        if (preg_match('/.*[0-9]{2}\.[0-9]{3}.*/', $model->denecke_teitge) && $model->purchase_number == '') {
            return "Model contains a number matching the purchase number format.";
        }

        return null;
    }
}