<?php

namespace App\Export;

use PHPExcel_IOFactory;
use PHPExcel;

class Excel
{

    private $excel = null;
    private $writer = null;
    private $config;

    /**
     * Excel constructor.
     */
    public function __construct()
    {
        // load excel class {from package}
        // store to local attributes
        // write excel as type in config(export.type)

        $this->config = config('export');
        $this->excel = new PHPExcel();
        $this->writer = PHPExcel_IOFactory::createWriter($this->excel, $this->config['type']);
    }

    public function title($title, $sheet = 0)
    {
        // create and set title for excel sheet

        $this->excel->createSheet($sheet);
        $this->excel->setActiveSheetIndex($sheet)->setTitle($title);
        return $this;
    }

    /**
     * @param array $data
     * @param $intoSheet
     * @param bool $firstRowAreColumnNames
     * @return $this
     */
    public function load(array $data, $intoSheet = null, $firstRowAreColumnNames = false)
    {
        // load to excel sheet

        $intoSheet = $intoSheet == null ? $this->excel->getActiveSheetIndex() : $intoSheet;
        $this->excel->setActiveSheetIndex($intoSheet)->fromArray($data);
        return $this;
    }

    /**
     * @param $fileName
     * @return bool
     */
    public function save($fileName)
    {
        // save excel file to config('export.path')
        // return true if success otherwise false

        $this->writer->save($this->config['path'] . $fileName . '.xlsx');
        return true;

    }
    
}