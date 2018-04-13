<?php

namespace App\History\Presenters;

use App\History\HistoryEntityPresenter;
use Grimm\LibraryBook;

class LibraryBookPresenter implements HistoryEntityPresenter
{

    /**
     * @return string
     */
    public function respondsTo()
    {
        return LibraryBook::class;
    }

    /**
     * @param \Grimm\LibraryBook $model
     * @return array
     */
    public function present($model)
    {
        return [
            'id' => $model->id,
            'title' => $model->title,
            'denecke_teitge' => $model->denecke_teitge,
            'trashed' => $model->trashed(),
            'links' => [
                'self' => route('librarybooks.show', [$model->id])
            ]
        ];
    }
}