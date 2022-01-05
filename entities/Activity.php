<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Activity
 * @package App
 *
 * @property integer id
 * @property integer model_id
 * @property string model_type
 * @property int parent_id
 * @property string parent_type
 * @property Model parent
 * @property array log
 * @property integer user_id
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property User user
 * @property \Illuminate\Database\Eloquent\Model model
 */
class Activity extends Model
{

    protected $table = 'activity';

    protected $fillable = [
        'model_id',
        'model_type',
        'parent_id',
        'parent_type',
        'log',
        'user_id'
    ];

    protected $casts = ['log' => 'array'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function parent()
    {
        return $this->morphTo('parent');
    }

    public function getType($pluralize = true)
    {
        $type = strtolower(last(explode('\\', $this->model_type)));

        if ($pluralize) {
            return Str::plural($type);
        }

        return $type;
    }

    public function getParentType($pluralize = true)
    {
        $type = strtolower(last(explode('\\', $this->parent_type)));

        if ($pluralize) {
            return Str::plural($type);
        }

        return $type;
    }

    public function getRoute()
    {
        return ($this->parent === null ? $this->getType() : $this->getParentType()) . '.show';
    }

    public function getRouteModel()
    {
        return $this->parent === null ? $this->model : $this->parent;
    }

    public function action()
    {
        return $this->log['action'];
    }

    public function isUpdatingActivity()
    {
        return $this->action() === 'updating';
    }

    public function after()
    {
        $after = $this->log['after'];

        return $this->rejectEmptyChanges($after);
    }

    public function before($rejectEmptyFields = true)
    {
        $before = collect($this->log['before']);

        if (is_string($rejectEmptyFields)) {
            return $before[$rejectEmptyFields] ?? '';
        }

        if (!$rejectEmptyFields) {
            return $before;
        }

        return $before->reject(function ($value) {
            return empty($value);
        });
    }

    /**
     * @param $after
     *
     * @return Collection
     */
    protected function rejectEmptyChanges($after)
    {
        $after = collect($after)->reject(function ($value, $key) {
            return empty($this->log['before'][$key]) && empty($value);
        });

        return $after;
    }
}
