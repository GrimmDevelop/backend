<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Letters\UpdateLetterCommentRequest;
use Grimm\Letter;
use Grimm\LetterComment;

class CommentsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Letter $letter
     * @return \Grimm\LetterComment
     */
    public function index(Letter $letter)
    {
        $comment = $letter->comment ?? LetterComment::query()->create([
                'entry' => '',
                'letter_id' => $letter->id
            ]);

        return fractal($comment, function (LetterComment $comment) {
            return [
                'id' => $comment->id,
                'entry' => $comment->entry,
            ];
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLetterCommentRequest $request
     * @param Letter $letter
     * @param LetterComment $comment
     * @return void
     */
    public function update(UpdateLetterCommentRequest $request, Letter $letter, LetterComment $comment)
    {
        $comment->entry = (string)$request->input('entry');
        $comment->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $letter
     * @param LetterComment $comment
     * @return void
     * @throws \Exception
     */
    public function destroy(Letter $letter, LetterComment $comment)
    {
        $comment->delete();
    }
}
