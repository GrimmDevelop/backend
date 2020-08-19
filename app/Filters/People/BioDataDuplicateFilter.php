<?php

namespace App\Filters\People;

use App\Filters\BooleanFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class BioDataDuplicateFilter extends BooleanFilter
{

    public function appliesTo()
    {
        return 'biodata_extractor';
    }

    public function displayString()
    {
        return 'filters.biodata_extractor';
    }

    protected function filterQuery(Builder $query)
    {
        $query->where('bio_data', DB::raw("CONCAT(IFNULL(birth_date,''), '-', IFNULL(death_date,''))"));
    }
}
