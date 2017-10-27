<?php

namespace App\Analyzer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class AnalyzeApplicator
{

    /**
     * @var Analyzer[]
     */
    protected $analyzers = [];

    /**
     * Registers a new database analyzer
     *
     * @param Analyzer $analyzer
     */
    public function registerAnalyzer(Analyzer $analyzer)
    {
        $this->analyzers[] = $analyzer;
    }

    /**
     * Registers multiple analyzer at once
     *
     * @param Analyzer[] $analyzers
     */
    public function registerAnalyzers(array $analyzers)
    {
        foreach ($analyzers as $analyzer) {
            $this->registerAnalyzer($analyzer);
        }
    }

    /**
     * Analyze given data with registered analyzer
     *
     * @param Builder $builder
     */
    public function analyze(Builder $builder)
    {
        $builder->where(function (Builder $builder) {
            foreach ($this->analyzers as $analyzer) {
                $builder->orWhere(function (Builder $builder) use ($analyzer) {
                    $analyzer->search($builder);
                });
            }
        });
    }

    /**
     * Returns a collection of analyze results (messages) for given model
     *
     * @param Model $model
     * @return Collection
     */
    public function resultFor(Model $model)
    {
        $result = collect();

        foreach ($this->analyzers as $analyzer) {
            $result[] = $analyzer->result($model);
        }

        return $result->filter();
    }
}