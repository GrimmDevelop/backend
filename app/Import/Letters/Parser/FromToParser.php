<?php

namespace App\Import\Letters\Parser;


use Grimm\Letter;
use Grimm\Location;
use App\Import\Parser\FieldParser;

class FromToParser implements FieldParser
{

    /**
     * @param $column
     * @param $field
     * @param Letter $letter
     */
    public function parse($column, $field, $letter)
    {
        if ($column == 'absendeort') {
            $location = $this->createLocationIfNotExisting($field);

            $letter->from()->associate($location);
            $letter->save();
        } else {
            if ($column == 'absort_ers') {
                $location_source = $letter->from;

                $location = $this->createLocationIfNotExisting($field);

                $letter->from()->associate($location);

                if ($location_source != null) {
                    $letter->from_source = $location_source->historical_name;
                }

                $letter->save();
            } else {
                if ($column == 'empf_ort') {
                    $location = $this->createLocationIfNotExisting($field);
                    $letter->to()->associate($location);
                    $letter->save();
                }
            }
        }
    }

    public function handledColumns()
    {
        return ['absendeort', 'absort_ers', 'empf_ort'];
    }

    /**
     * @param string $historicalName
     * @return Location
     */
    protected function createLocationIfNotExisting($historicalName)
    {
        /** @var Location $location */
        $location = Location::query()->where('historical_name', $historicalName)->firstOrCreate([
            'historical_name' => $historicalName,
        ]);

        return $location;
    }
}