<?php

namespace Grimm\Transformers;

use Grimm\LetterPersonAssociation;
use League\Fractal\TransformerAbstract;

class LetterPersonAssociationTransformer extends TransformerAbstract
{

    public function transform(LetterPersonAssociation $association)
    {
        return [
            'name' => $association->name,
            'person_id' => $association->person_id,
        ];
    }
}