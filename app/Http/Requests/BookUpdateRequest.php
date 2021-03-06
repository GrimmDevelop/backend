<?php

namespace App\Http\Requests;

use Grimm\Book;

class BookUpdateRequest extends Request
{

    /**
     * Always returns true, the controller
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('books.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'short_title' => 'nullable|max:255',
            'year' => 'nullable|numeric|max:9999',
            'volume' => 'nullable|numeric|min:1',
            'volume_irregular' => 'nullable|numeric|min:1',
            'edition' => 'nullable|numeric|min:1',
            'source' => 'nullable|string',
            'notes' => 'nullable|string',
            'grimm' => 'nullable|boolean',
        ];
    }

    /**
     * Persists changes to the database
     *
     * @param Book $book
     *
     * @return bool
     */
    public function persist(Book $book)
    {
        $book->title = $this->input('title');
        $book->short_title = $this->input('short_title') ?: null;

        $book->volume = (int)$this->input('volume') ?: null;
        $book->volume_irregular = (int)$this->input('volume_irregular') ?: null;
        $book->edition = (int)$this->input('edition') ?: null;

        //$book->year = (int)$this->input('year') ?: null;

        $book->source = $this->input('source');
        $book->notes = $this->input('notes');
        $book->grimm = (bool)$this->input('grimm');

        return $book->save();
    }
}
