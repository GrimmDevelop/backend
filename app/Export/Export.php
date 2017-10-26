<?php

namespace App\Export;

use Illuminate\Support\Collection;

Interface Export
{

    public function title($title, $sheet = 0);

    public function load(Collection $data, $intoSheet = null, $firstRowAreColumnNames = false);

    public function save($fileName, $overwriteExistingFile = false);

}