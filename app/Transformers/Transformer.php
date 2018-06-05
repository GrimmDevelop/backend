<?php

namespace App\Transformers;

interface Transformer
{

    /**
     * Transforms given data into something else
     *
     * @param $data
     * @return mixed
     */
    public function transform($data);

}