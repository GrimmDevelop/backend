<?php

namespace Grimm\Grids;

use App\Grid\Column;
use App\Grid\Grid;
use Grimm\Person;
use Grimm\PersonInheritance;
use Grimm\PersonPrint;
use Grimm\PersonReference;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class PersonGrid extends Grid
{

    public function __construct(Person $person)
    {
        parent::__construct('people', [
            new Column('ddb_id', true),
            new Column('full_name', false),
            new Column('full_first_name', false),
            new Column('last_name', true),
            new Column('first_name', true),
            new Column('birth_date', false),
            new Column('death_date', false),
            new Column('bio_data_source', true, function () use ($person) {
                return Str::limit($person->bio_data_source, 20, '[...]');
            }),
            new Column('bio_data', true, function () use ($person) {
                return Str::limit($person->bio_data, 20, '[...]');
            }),
            new Column('add_bio_data', true, function () use ($person) {
                return Str::limit($person->add_bio_data, 20, '[...]');
            }),
            new Column('is_organization', false),
            new Column('auto_generated', false),
            new Column('source', true, function () use ($person) {
                return Str::limit($person->source, 20, '[...]');
            }),
            new Column('prints', false, function () use ($person) {
                return $person->prints->map(function (PersonPrint $print) {
                    return $print->entry;
                })->implode('; ');
            }, 'prints.entry'),
            new Column('references', false, function () use ($person) {
                return $person->references->map(function (PersonReference $reference) {
                    return $reference->reference->normalizeName();
                })->implode('; ');
            }, 'references.entry'),
            new Column('inheritances', false, function () use ($person) {
                return $person->inheritances->map(function (PersonInheritance $inheritance) {
                    return $inheritance->entry;
                })->implode('; ');
            }, 'inheritances.entry'),
        ]);
    }
}
