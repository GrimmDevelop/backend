<?php

namespace Grimm;

trait HasActivity
{

    public static function bootHasActivity()
    {
        static::deleted(function ($model) {
            /** @var HasActivity $model */
            // $model->activities()->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activities()
    {
        return $this->morphMany(Activity::class, 'model');
    }
}
