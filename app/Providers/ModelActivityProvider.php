<?php

namespace App\Providers;

use Grimm\Activity;
use Grimm\AuctionCatalogue;
use Grimm\Book;
use Grimm\Letter;
use Grimm\LetterApparatus;
use Grimm\LetterAttachment;
use Grimm\LetterComment;
use Grimm\LetterPrint;
use Grimm\LetterTranscription;
use Grimm\LibraryBook;
use Grimm\LibraryPerson;
use Grimm\Person;
use Grimm\PersonInheritance;
use Grimm\PersonPrint;
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
        if (app()->runningInConsole()) {
            return;
        }

        $this->registerModel(Letter::class);
        $this->registerModel(LetterApparatus::class, 'letter');
        $this->registerModel(LetterAttachment::class, 'letter');
        $this->registerModel(LetterComment::class, 'letter');
        $this->registerModel(LetterPrint::class, 'letter');
        $this->registerModel(LetterTranscription::class, 'letter');
        $this->registerModel(AuctionCatalogue::class, 'letter');

        $this->registerModel(Book::class);

        $this->registerModel(Person::class);
        $this->registerModel(PersonInheritance::class, 'person');
        $this->registerModel(PersonPrint::class, 'person');

        $this->registerModel(LibraryBook::class);
        $this->registerModel(LibraryPerson::class);
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

    protected function registerModel($class, $parentModel = null)
    {
        $class::created(function (Model $model) use ($parentModel) {
            $this->logCreating($model, $parentModel);
        });

        $class::updating(function (Model $model) use ($parentModel) {
            $this->logUpdating($model, $parentModel);
        });

        $class::deleting(function (Model $model) use ($parentModel) {
            $this->logDeleting($model, $parentModel);
        });

        $class::restored(function (Model $model) use ($parentModel) {
            $this->logRestoring($model, $parentModel);
        });
    }

    protected function log($model, $log, $parent = null)
    {
        Activity::create(array_merge([
            'model_id' => $model->id,
            'model_type' => get_class($model),
            'log' => $log,
            'user_id' => auth()->user()->id,
        ], $parent !== null ? [
            'parent_id' => $model->{$parent}->id,
            'parent_type' => $model->{$parent}->getMorphClass(),
        ] : []));
    }

    protected function logCreating(Model $model, $parentModel)
    {
        $this->log($model, [
            'action' => 'creating',
            'after' => $model->getDirty(),
        ], $parentModel);
    }

    protected function logUpdating(Model $model, $parentModel)
    {
        $before = $this->getBeforeFromModel($model);

        if (!array_key_exists('deleted_at', $before)) {
            $this->log($model, [
                'action' => 'updating',
                'before' => $before,
                'after' => $model->getDirty(),
            ], $parentModel);
        }
    }

    protected function logDeleting(Model $model, $parentModel)
    {
        $this->log($model, [
            'action' => 'deleting',
            'before' => $model->getOriginal(),
        ], $parentModel);
    }

    protected function logRestoring(Model $model, $parentModel)
    {
        $this->log($model, [
            'action' => 'restoring',
            'after' => $model->getOriginal(),
        ], $parentModel);
    }

    protected function getBeforeFromModel(Model $model)
    {
        return array_intersect_key($model->getOriginal(), $model->getDirty());
    }

}
