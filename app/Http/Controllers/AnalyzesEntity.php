<?php

namespace App\Http\Controllers;

use App\Analyzer\AnalyzeApplicator;
use Illuminate\Database\Eloquent\Builder;

trait AnalyzesEntity
{

    /**
     * @var AnalyzeApplicator
     */
    protected $analyzer;

    public function analyze(Builder $builder)
    {
        $this->analyzer = app(AnalyzeApplicator::class);

        if (method_exists($this, 'analyzers')) {
            $analyzers = $this->analyzers();

            $this->analyzer->registerAnalyzers($analyzers);
        }

        view()->composer('*', function ($view) {
            $view->with(['analyzer' => $this->analyzer]);
        });

        return $this->analyzer->analyze($builder);
    }
}