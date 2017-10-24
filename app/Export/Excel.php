<?php

namespace App\Export;

class Excel
{
    public function __construct()
    {
        // load excel class {from package}
        //  store to local attributes
    }

    public function title($title, $sheet = 1)
    {
        // set title for excel sheet

        return $this;
    }

    public function load($data, $sheet, $firstRowAreColumnNames = false)
    {
        // load to excel sheet

        return $this;
    }

    public function save($fileName)
    {
        // save excel file to config('export.path')
        // return true if success otherwise false
        
        return true;
    }


}