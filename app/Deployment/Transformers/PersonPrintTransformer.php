<?php

namespace App\Deployment\Transformers;

use Grimm\PersonPrint;
use League\Fractal\TransformerAbstract;

class PersonPrintTransformer extends TransformerAbstract {

    public function transform(PersonPrint $item)
    {
        return [
            'entry' => $item->entry,
            'year'  => ($item->year === null) ? null : floor($item->year),
        ];
    }
}
