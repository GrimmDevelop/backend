<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use InvalidArgumentException;

trait CollectPrefixes
{

    /**
     * @param $column
     * @param int $length
     * @return \Illuminate\Database\Query\Builder
     */
    public static function prefixesOfLength($column, $length = 2)
    {
        /** @var Model $instance */
        $instance = new static;

        if (is_array($instance->prefixable) && in_array($column, $instance->prefixable)) {
            return $instance->query()->toBase()->selectRaw('DISTINCT(SUBSTRING(' . $column . ', 1, ?)) as prefix',
                [$length])->orderBy('prefix');
        }

        throw new InvalidArgumentException('Column is not in prefixable array!');
    }

    /**
     * Scope records using a prefix
     *
     * @param        $query
     * @param        $letter
     * @param string $field
     *
     * @return Builder
     */
    public function scopeByPrefix(Builder $query, $letter, $field = 'last_name')
    {
        $letter = Str::lower($letter);

        return $query->where($field, 'like', $letter . '%');
    }
}
