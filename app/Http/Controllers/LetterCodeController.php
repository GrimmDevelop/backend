<?php

namespace App\Http\Controllers;

use Exception;
use Grimm\Letter;
use Grimm\LetterCode;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LetterCodeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Letter $letter
     * @return LetterCode[]|Collection
     * @throws AuthorizationException
     */
    public function index(Letter $letter)
    {
        $this->authorize('letters.update');

        return $this->codesMapWithKeys();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Letter $letter
     * @return LetterCode[]\Illuminate\Http\RedirectResponse|mixed
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function store(Request $request, Letter $letter)
    {
        $this->authorize('letters.update');

        $this->validate($request, [
            'codeName' => 'required'
        ]);

        $code = new LetterCode();

        $code->name = $request->get('codeName');
        $code->error_generated = $request->get('codeErrorGenerated');
        $code->internal = $request->get('codeInternal');
        $code->save();

        return $this->codesMapWithKeys();
    }

    /**
     * * Update the specified resource in storage.
     *
     * @param Request $request $request
     * @param Letter $letter
     * @param $codeId
     * @return LetterCode
     * @throws AuthorizationException
     */
    public function update(Request $request, Letter $letter, $codeId)
    {
        $this->authorize('letters.update');

        /** @var LetterCode $code */
        $code = LetterCode::query()->findOrFail($codeId);

        $code->name = $request->get('codeName');
        $code->error_generated = $request->get('codeErrorGenerated');
        $code->internal = $request->get('codeInternal');

        $code->save();

        if ($request->ajax()) {
            return $code;
        }

        return redirect()->route('letters.show', ['letters' => $letter->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $letter
     * @param $codeId
     * @return LetterCode
     * @throws AuthorizationException
     */
    public function destroy(Letter $letter, $codeId)
    {
        $this->authorize('letters.update');

        /** @var LetterCode $code */
        $code = LetterCode::query()->findOrFail($codeId);

        try {
            $code->delete();
        } catch (Exception $e) {
        }

        return $code;
    }

    /**
     * @return LetterCode[]|Collection
     */
    private function codesMapWithKeys()
    {
        return LetterCode::query()
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item];
            });
    }
}
