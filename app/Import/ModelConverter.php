<?php

namespace App\Import;

use XBase\Record;

interface ModelConverter
{

    public function setupEntity();

    public function preflight();

    public function convert(Record $record, $columns);

    public function type();
}