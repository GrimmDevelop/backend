<?php

namespace App\Import\Letters\Parser;

use Grimm\Letter;
use App\Import\Parser\FieldParser;

class IdParser implements FieldParser
{

    /**
     * @param $column
     * @param $field
     * @param Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        switch ($column) {
            case 'nr':
                $this->setId($letter, $field);
                break;
            case 'nr_1992':
                $letter->id_till_1992 = (int)$field;
                break;
            case 'nr_1997':
                $letter->id_till_1997 = (int)$field;
                break;
        }

        $letter->save();
    }

    public function handledColumns()
    {
        return ['nr', 'nr_1992', 'nr_1997'];
    }

    /**
     * @param Letter $letter
     * @param $field
     */
    private function setId($letter, $field)
    {
        // TODO: make them fix their db to not contain duplicates!
        $id = (int)$field;
        if ($id == 10865) {
            // Very ugly, but as these entries are processed in different jobs,
            // this is for now the easiest way^^
            $current = 0;

            while (file_exists(storage_path('app') . '/importfix-' . $current . '.txt')) {
                $id = $id * 10;

                $current++;
            }

            file_put_contents(storage_path('app') . '/importfix-' . $current . '.txt', $id);
        }

        $letter->id = (int)$id;
    }
}