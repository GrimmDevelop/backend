<?php

namespace App\Http\Controllers;

use Grimm\Letter;
use Grimm\LetterCode;
use Grimm\LetterInformation;
use Illuminate\Http\Request;

class LetterInformationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response [Information[],codes[]]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Letter $letter)
    {
        $this->authorize('letters.update');

        $codes = new LetterCode();

        return response()->json(["information" => $letter->information, "codes" => $codes->all('id','name')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse [Information[],codes[]]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Letter $letter)
    {
        $this->authorize('letters.update');

        $information = new LetterInformation();
        $code=new LetterCode();

        $information->data = $request->get('data');
        $information->letter_code_id = $request->get('code');

        $letter->Information()->save($information);

        if ($request->ajax()) {
            return response()->json(["information" => $letter->information, "codes" => $code->all('id','name')]);
        }

        return redirect()->route('letters.show', ['letters' => $letter->id]);
    }
}
