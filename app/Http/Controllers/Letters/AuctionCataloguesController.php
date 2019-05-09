<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyCatalogueRequest;
use App\Http\Requests\DestroyLetterRequest;
use App\Http\Requests\StoreCatalogueRequest;
use App\Http\Requests\UpdateCatalogueRequest;
use Grimm\AuctionCatalogue;
use Grimm\Letter;

class AuctionCataloguesController extends Controller
{

    /**
     * @param Letter $letter
     * @return \Grimm\LetterAttachment[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Letter $letter)
    {
        $this->authorize('letters.update');

        return $letter->auctionCatalogues;
    }

    /**
     * @param UpdateCatalogueRequest $request
     * @param Letter $letter
     * @param AuctionCatalogue $auctionCatalogue
     * @return \Grimm\LetterAttachment[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCatalogueRequest $request, Letter $letter, AuctionCatalogue $auctionCatalogue)
    {
        $this->authorize('letters.update');

        return $request->persist($auctionCatalogue);
    }

    /**
     * @param StoreCatalogueRequest $request
     * @param Letter $letter
     * @return \Grimm\LetterPrint[]|\Illuminate\Http\RedirectResponse|\Illuminate\Support\Collection
     */
    public function store(StoreCatalogueRequest $request, Letter $letter)
    {
        $request->persist($letter);

        if ($request->ajax()) {
            return $letter->auctionCatalogues;
        }

        return redirect()->route('letters.show', [$letter]);
    }

    public function destroy(DestroyCatalogueRequest $request, Letter $letter, AuctionCatalogue $auctionCatalogue)
    {
        $request->persist($auctionCatalogue);

        return $letter->auctionCatalogues;
    }
}