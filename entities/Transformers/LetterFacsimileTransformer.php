<?php

namespace Grimm\Transformers;

use Grimm\Facsimile;
use League\Fractal\TransformerAbstract;

class LetterFacsimileTransformer extends TransformerAbstract
{
    public function transform(Facsimile $facsimile)
    {
        return [
            'entry' => $facsimile->entry,
            'year' => $facsimile->year
        ];
    }
}