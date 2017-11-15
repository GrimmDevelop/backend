<?php

namespace App\Export;

Interface Export
{

    public function title($title, $sheet = 0);

    public function load($data, $intoSheet = null, $useKeysAsColumnNames = false);

    public function save($fileName, $overwriteExistingFile = false);

}