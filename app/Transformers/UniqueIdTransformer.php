<?php

namespace App\Transformers;

class UniqueIdTransformer implements Transformer
{

    protected $base = 36;
    protected $digits = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    protected $maxDigits = 6;

    /**
     * Transforms given data into something else
     *
     * @param $data
     * @return mixed
     */
    public function transform($data)
    {
        if ($data < $this->base) {
            return '00' . $this->digits[$data];
        }

        $sb = str_pad('', $this->maxDigits);

        $current = $data;
        $offset = $this->maxDigits;

        while ($current > 0) {
            $sb[--$offset] = $this->digits[$current % $this->base];
            $current = floor($current / $this->base);
        }

        return str_pad(trim($sb), 3, '0', STR_PAD_LEFT);
    }
}