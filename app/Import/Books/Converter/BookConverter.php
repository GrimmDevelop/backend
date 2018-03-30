<?php

namespace App\Import\Books\Converter;

use App\Import\Converter\DBFRecordConverter;
use App\Import\ModelConverter;
use Grimm\Book;

class BookConverter implements ModelConverter
{
    use DBFRecordConverter;

    public function setupEntity()
    {
        $b = new Book();
        $b->save();

        return $b;
    }

    /**
     * Returns model type which is converted
     *
     * @return string
     */
    public function type()
    {
        return Book::class;
    }
}
