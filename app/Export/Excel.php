<?php

namespace App\Export;

use function array_merge;
use function collect;
use function file_exists;
use Illuminate\Support\Collection;
use function in_array;
use League\Flysystem\FileExistsException;
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

        if (!in_array($title, $this->excel->getSheetNames())) {
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
            $this->excel->setActiveSheetIndex($intoSheet)->fromArray(array_merge([$data[0]->keys()->toArray()], $data[1]->toArray()));
        } else {
            $this->excel->setActiveSheetIndex($intoSheet)->fromArray($data->toArray());
        }
        return $this;
    }

    /**
     * Saves given data to export directory.
     * If successful it returns the full file name otherwise null
     *
     * @param $fileName
     * @param bool $overwriteExistingFile
     * @return null|string
     * @throws FileExistsException
     */
    public function save($fileName, $overwriteExistingFile = false)
    {
        // save excel file to config('export.path')
        // return true if success otherwise false
        // when  $overwriteExistingFile = true
        //we write over  file and over  sheet if exists

        $path = $this->config['path'] . '/' . $fileName . '.xlsx';

        //remove the default empty sheet
        $this->excel->removeSheetByIndex($this->excel->getSheetCount() - 1);

        if (!$overwriteExistingFile && file_exists($path)) {
            throw new FileExistsException('File "' . $fileName . '" already exists!');
        }

        try {
            $this->writer->save($path);

            return $path;
        } catch (\Exception $e) {
            return null;
        }
    }

}