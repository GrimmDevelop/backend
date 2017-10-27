<?php

namespace App\Analyzer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class RegexpAnalyzer implements Analyzer
{

    /**
     * The actual regular expression which searches inside the database.
     * All fields (from the method fields()) have to occur inside the expression as matching indices.
     * The delimiter is always "/" so any occurrence of "/" inside the expression has to be escaped.
     *
     * @return string
     */
    abstract protected function regexp(): string;

    /**
     * Field to search with regular expression
     *
     * @return string
     */
    abstract protected function appliesTo(): string;

    /**
     * All field which are found by the regular expression
     *
     * @return array
     */
    abstract protected function fields(): array;

    /**
     * The messages displayed if something was found by the regular expression
     *
     * @return string
     */
    abstract protected function displayString(): string;

    /**
     * Adds search requirements to given builder
     *
     * @param Builder $builder
     */
    public function search(Builder $builder)
    {
        $builder->where($this->appliesTo(), 'regexp', $this->pcreToPosix($this->regexp()))
            ->where(function (Builder $b) {
                foreach ($this->fields() as $field) {
                    $b->where($field, null)
                        ->orWhere($field, '');
                }
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
        if (preg_match(
                "/" . $this->regexp() . "/",
                $model->{$this->appliesTo()},
                $matches
            ) && $this->checkFields($model)) {

            $fieldMatches = [];

            foreach ($this->fields() as $field) {
                $fieldMatches[] = $matches[$field];
            }

            return sprintf($this->displayString(), ...$fieldMatches);
        }

        return null;
    }

    protected function checkFields($model)
    {
        foreach ($this->fields() as $field) {
            if ($model->{$field} == '') {
                return true;
            }
        }

        return false;
    }

    /**
     * removes all named matches inside a regular expression due to incompatibility in MySQL
     *
     * @param $regexp
     * @return mixed
     */
    protected function pcreToPosix($regexp)
    {
        return preg_replace("/\?\<.*?\>/", '', $regexp);
    }
}