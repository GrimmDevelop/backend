<?php

namespace App\Upload;

use Flow\Config;
use Flow\File;

trait UploadsFiles
{

    /**
     * @return File
     */
    protected function initFlowFile()
    {
        $config = new Config();

        if (!is_dir(storage_path() . '/uploads/temp/')) {
            mkdir(storage_path() . '/uploads/temp/', 0775, true);
        }

        $config->setTempDir(storage_path() . '/uploads/temp/');

        return new File($config);
    }
}