<?php

namespace Grimm\Grids;

use App\Grid\Column;
use App\Grid\Grid;
use Grimm\Person;

class PersonGrid extends Grid
{

    public function __construct(Person $person)
    {
        parent::__construct('people', [
            new Column('full_name', true, function () use ($person) {

                return $person->fullName();
            }),
            new Column('last_name', false),
            new Column('first_name', false),
            new Column('birth_date', false),
            new Column('death_date', false),
            new Column('bio_data_source', true, function () use ($person) {
                return str_limit($person->bio_data_source, 20, '[...]');
            }),
            new Column('bio_data', true, function () use ($person) {
                return str_limit($person->bio_data, 20, '[...]');
            }),
            new Column('add_bio_data', true, function () use ($person) {
                return str_limit($person->add_bio_data, 20, '[...]');
            }),
            new Column('is_organization', false),
            new Column('auto_generated', false),
            new Column('source', true, function () use ($person) {
                return str_limit($person->source, 20, '[...]');
            }),
            new Column('created_at', false),
            new Column('updated_at', false),
            new Column('deleted_at', false),
        ]);
    }
}