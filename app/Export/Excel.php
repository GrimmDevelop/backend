<?php

namespace App\Export;

use League\Flysystem\Config;
use PHPExcel_IOFactory;
use PHPExcel;

class Excel
{

    private $excel = null;
    private $writer;
    private $config;

    /**
     * Excel constructor.
     */
    public function __construct()
    {
        // load excel class {from package}
        // store to local attributes
        // write excel as type in config(export.type)

        $this->config = \config('export');
        $this->excel = new PHPExcel();
        $this->writer = PHPExcel_IOFactory::createWriter($this->excel, $this->config['type']);

    }

    public function title($title, $sheet = 1)
    {
        // set title for excel sheet
        $this->excel->setActiveSheetIndex($sheet)->setTitle($title);
        return $this;
    }

    /**
     * @param array $data
     * @param integer $sheet
     * @param bool $firstRowAreColumnNames
     * @return $this
     */
    public function load(array $data, $sheet, $firstRowAreColumnNames = false)
    {
        // load to excel sheet

        $this->excel->setActiveSheetIndex($sheet);
        $this->excel->getActiveSheet()->fromArray($data);

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
        if(file($this->config['path'].$fileName)){

        }
        $this->writer->save($this->config['path'] . $fileName);

        return true;
    }


}