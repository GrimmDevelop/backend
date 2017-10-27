<?php

namespace App\Export;

use function array_merge;
use function collect;
use function file_exists;
use Illuminate\Support\Collection;
use function in_array;
use PHPExcel_IOFactory;
use PHPExcel;
use function storage_path;

class Excel implements Export
{

    private $excel = null;
    private $writer = null;
    private $reader = null;
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

    /**
     * @param string $title
     * @param int $sheet
     * @return $this
     */
    public function title($title, $sheet = 0)
    {
        // create and set title for excel sheet
        //and if there is sheet with this title rename it

        if (not(in_array($title, $this->excel->getSheetNames()))) {
            $this->excel->createSheet($sheet);
        }
        $this->excel->setActiveSheetIndex($sheet)->setTitle($title);
        return $this;
    }

    /**
     * @param Collection $data
     * @param $intoSheet
     * @param bool $firstRowAreColumnNames
     * @return $this
     */
    public function load(Collection $data, $intoSheet = null, $firstRowAreColumnNames = false)
    {
        // load to excel sheet

        $intoSheet = $intoSheet == null ? $this->excel->getActiveSheetIndex() : $intoSheet;
        if ($firstRowAreColumnNames) {
            $keys = collect($data[0])->keys();
            $this->excel->setActiveSheetIndex($intoSheet)->fromArray(array_merge([$keys->toArray()], $data->toArray()));
        } else {
            $this->excel->setActiveSheetIndex($intoSheet)->fromArray($data->toArray());
        }
        return $this;
    }

    /**
     * @param $fileName
     * @param bool $overwriteExistingFile
     * @return bool
     */
    public function save($fileName, $overwriteExistingFile = false)
    {
        // save excel file to config('export.path')
        // return true if success otherwise false
        // when  $overwriteExistingFile = true
        //we write over  file and over  sheet if exists

        //remove the default empty sheet
        $this->excel->removeSheetByIndex($this->excel->getSheetCount() - 1);

        if (file_exists($this->config['path'] . $fileName . '.xlsx') && $overwriteExistingFile) {

            $this->reader = PHPExcel_IOFactory::createReaderForFile($this->config['path'] . $fileName . '.xlsx');
            $oldSheets = $this->reader->load($this->config['path'] . $fileName . '.xlsx');
            //add the  old sheets to new excel file
            foreach ($oldSheets->getAllSheets() as $sheet) {
                if (in_array($sheet->getTitle(), $this->excel->getSheetNames())) {

                    $mergeData = array_merge($sheet->toArray(),
                        $this->excel->getSheetByName($sheet->getTitle())->toArray());

                    $this->excel->setActiveSheetIndexByName($sheet->getTitle())
                        ->fromArray($mergeData);
                } else {

                    $this->excel->addSheet($sheet, $this->excel->getSheetCount() + 1);

                }
            }
        }

        $this->writer->save($this->config['path'] . $fileName . '.xlsx');

        return $this->config['path'] . $fileName . '.xlsx';
    }

}