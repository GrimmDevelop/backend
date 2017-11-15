<?php

namespace App\Export;

use function array_merge;
use function collect;
use function file_exists;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use function in_array;
use JsonSerializable;
use League\Flysystem\FileExistsException;
use PHPExcel_IOFactory;
use PHPExcel;
use function storage_path;
use Traversable;

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
     * @param $data
     * @param $intoSheet
     * @param bool $useKeysAsColumnNames
     * @return $this
     */
    public function load($data, $intoSheet = null, $useKeysAsColumnNames = true)
    {
        // load to excel sheet
        $intoSheet = $intoSheet == null ? $this->excel->getActiveSheetIndex() : $intoSheet;

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

        $this->excel
            ->setActiveSheetIndex($intoSheet)
            ->fromArray($preparedData);

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