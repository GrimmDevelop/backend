<?php

namespace App\Export;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use JsonSerializable;
use League\Flysystem\FileExistsException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Traversable;

class Excel implements Export
{

    private $excel;
    private $writer;

    /**
     * Excel constructor.
     */
    public function __construct()
    {
        $this->excel = new Spreadsheet();

        $this->writer = new Xlsx($this->excel);
    }

    /**
     * activate sheet and create it if non existing
     *
     * @param $sheet
     * @return $this
     */
    public function sheet($sheet = null)
    {
        if ($sheet !== null) {
            $this->createSheetIfNotExistent($sheet);

            try {
                $this->excel->setActiveSheetIndex($sheet);
            } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            }
        }

        return $this;
    }

    /**
     * @param string $title
     * @param int $sheet
     * @return $this
     */
    public function title($title, $sheet = null)
    {
        try {
            $this->sheet($sheet);

            $this->excel->getActiveSheet()->setTitle($title);
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
        }

        return $this;
    }

    /**
     * @param $data
     * @param $intoSheet
     * @param bool $useKeysAsColumnNames
     * @return $this
     */
    public function load($data, $intoSheet = null, $useKeysAsColumnNames = true)
    {
        // load to excel sheet
        $intoSheet = $intoSheet === null ? $this->excel->getActiveSheetIndex() : $intoSheet;

        // always use collections
        $data = collect($data)
            ->map(function ($row) {
                if (is_array($row)) {
                    return $row;
                } elseif ($row instanceof Collection) {
                    return $row->all();
                } elseif ($row instanceof Arrayable) {
                    return $row->toArray();
                } elseif ($row instanceof Jsonable) {
                    return json_decode($row->toJson(), true);
                } elseif ($row instanceof JsonSerializable) {
                    return $row->jsonSerialize();
                } elseif ($row instanceof Traversable) {
                    return iterator_to_array($row);
                }

                return (array)$row;
            });

        if ($useKeysAsColumnNames) {
            // prepend keys as row
            $keys = array_keys($data[0]);

            $data->prepend($keys);
        }

        $preparedData = $data->all();

        $this->sheet($intoSheet);

        try {
            $this->excel
                ->getActiveSheet()
                ->fromArray($preparedData);
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
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

        $path = config('export.path') . '/' . $fileName . '.xlsx';

        //remove the default empty sheet
        // $this->excel->removeSheetByIndex($this->excel->getSheetCount() - 1);

        if (!$overwriteExistingFile && file_exists($path)) {
            throw new FileExistsException('File "' . $fileName . '" already exists!');
        }

        try {
            $this->writer->save($path);

            return $path;
        } catch (Exception $e) {
            return null;
        }
    }

    private function createSheetIfNotExistent($sheet)
    {
        if ($sheet > $this->excel->getSheetCount() - 1) {
            try {
                $this->excel->createSheet($sheet)
                    ->setTitle('new sheet ' . $sheet);
            } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                // TODO: handle exception
            }
        }
    }

}