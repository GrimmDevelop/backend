<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\Controller;
use Grimm\Letter;
use Grimm\LetterAttachment;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Letter $letter
     * @return \Grimm\LetterAttachment[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Letter $letter)
    {
        $this->authorize('letters.update');

        return $letter->attachments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @return LetterAttachment[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Letter $letter)
    {
        $this->authorize('letters.update');

        $attachment = new LetterAttachment();
        $attachment->entry = $request->get('entry');
        $letter->attachments()->save($attachment);

        if ($request->ajax()) {
            return $letter->attachments;
        }

        return redirect()->route('letters.show', [$letter]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @param  int $attachmentId
     * @return LetterAttachment
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Letter $letter, $attachmentId)
    {
        $this->authorize('letters.update');

        /** @var LetterAttachment $attachment */
        $attachment = $letter->attachments()->find($attachmentId);

        $attachment->entry = $request->get('entry');

        $attachment->save();

        return $attachment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $letter
     * @param $attachmentId
     * @return \Grimm\LetterPrint[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Letter $letter, $attachmentId)
    {
        $this->authorize('letters.update');

        $letter->attachments()->find($attachmentId)->delete();

        return $letter->prints;
    }
}
