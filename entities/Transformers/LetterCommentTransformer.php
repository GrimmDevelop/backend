<?php

namespace Grimm\Transformers;

use Grimm\LetterComment;
use League\Fractal\TransformerAbstract;

class LetterCommentTransformer extends TransformerAbstract
{
    /**
     * @param LetterComment $comment
     * @return array
     */
    public function transform(LetterComment $comment)
    {
        return[
            'id' => $comment->id,
            'entry' => $comment->entry,
            'letter' => $comment->letter
        ];
    }
}