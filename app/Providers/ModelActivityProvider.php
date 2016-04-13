<?php

namespace App\Providers;

use App\Activity;
use Auth;
use Grimm\Book;
use Grimm\Person;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class ModelActivityProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Book::created(function (Model $model) {
            $this->logCreating($model);
        });

        Book::updating(function (Model $model) {
            $this->logUpdating($model);
        });

        Book::deleting(function (Model $model) {
            $this->logDeleting($model);
        });

        Person::created(function (Model $model) {
            $this->logCreating($model);
        });

        Person::updating(function (Model $model) {
            $this->logUpdating($model);
        });

        Person::deleting(function (Model $model) {
            $this->logDeleting($model);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function log($model, $log)
    {
        Activity::create([
            'model_id' => $model->id,
            'model_type' => get_class($model),
            'log' => $log,
            'user_id' => Auth::user()->id,
        ]);
    }

    protected function logCreating(Model $model)
    {
        $this->log($model, [
            'action' => 'creating',
            'after' => $model->getDirty(),
        ]);
    }

    protected function logUpdating(Model $model)
    {
        $this->log($model, [
            'action' => 'updating',
            'before' => $this->getBeforeFromModel($model),
            'after' => $model->getDirty(),
        ]);
    }

    protected function logDeleting(Model $model)
    {
        $this->log($model, [
            'action' => 'deleting',
            'before' => $model->getOriginal(),
        ]);
    }

    protected function getBeforeFromModel(Model $model)
    {
        return array_intersect_key($model->getOriginal(), $model->getDirty());
    }
}
