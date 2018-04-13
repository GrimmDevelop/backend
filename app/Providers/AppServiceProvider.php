<?php

namespace App\Providers;

use App\Deployment\DeploymentService;
use App\Filters\FilterApplicator;
use App\History\HistoryEntityTransformer;
use App\History\Presenters\BookPresenter;
use App\History\Presenters\LibraryBookPresenter;
use App\History\Presenters\PersonPresenter;
use App\Import\ImportService;
use Carbon\Carbon;
use Grimm\Person;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Spatie\Valuestore\Valuestore;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        Person::$unknownName = trans('people.unknownName');

        Validator::extend('equals', function ($attribute, $value, $parameters, $validator) {
            if (!isset($parameters[0])) {
                throw new \InvalidArgumentException("at least one parameter is required");
            }

            return $value == $parameters[0];
        });

        Validator::extend('unequals', function ($attribute, $value, $parameters, $validator) {
            if (!isset($parameters[0])) {
                throw new \InvalidArgumentException("at least one parameter is required");
            }

            return $value != $parameters[0];
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ImportService::class, function () {
            return new ImportService(Valuestore::make(storage_path('app/import.json')));
        });

        $this->app->singleton(DeploymentService::class, function () {
            return new DeploymentService(Valuestore::make(storage_path('app/deployment.json')));
        });

        $this->app->singleton(HistoryEntityTransformer::class, function () {
            return new HistoryEntityTransformer([
                new PersonPresenter(),
                new BookPresenter(),
                new LibraryBookPresenter(),
            ]);
        });

        $this->app->singleton(FilterApplicator::class, function () {
            return new FilterApplicator();
        });

        \URL::macro('filtered_to', function ($to, $deltaFilters = []) {
            /** @var FilterApplicator $filterApplicator */
            $filterApplicator = app(FilterApplicator::class);

            $queryString = $filterApplicator->buildQueryString($deltaFilters);

            if (empty($queryString)) {
                return $to;
            }

            return $to . '?' . $queryString;
        });

        \URL::macro('filtered', function ($deltaFilters = []) {
            return url()->filtered_to(url()->current(), $deltaFilters);
        });
    }
}
