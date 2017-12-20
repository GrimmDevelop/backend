<?php

namespace App\Http\Controllers;

use App\Analyzer\Library\NotesFromJacobAnalyzer;
use App\Analyzer\Library\NotesFromWilhelmAnalyzer;
use App\Analyzer\Library\PublishingDataAnalyzer;
use App\Analyzer\Library\PurchaseNumberAnalyzer;
use App\Events\DestroyLibraryEvent;
use App\Events\DestroyLibraryRelationEvent;
use App\Events\StoreLibraryEvent;
use App\Events\UpdateLibraryEvent;
use App\Export\Excel;
use App\Filters\Library\BookNoFilter;
use App\Filters\Library\DeneckeFilter;
use App\Filters\Library\FolkFilter;
use App\Filters\Library\TitleFilter;
use App\Filters\Shared\OnlyTrashedFilter;
use App\Filters\Shared\PrefixFilter;
use App\Filters\Shared\SortFilter;
use App\Http\Requests\DestroyLibraryRelationRequest;
use App\Http\Requests\DestroyLibraryRequest;
use App\Http\Requests\IndexLibraryRequest;
use App\Http\Requests\ShowLibraryRequest;
use App\Http\Requests\StoreLibraryRelationRequest;
use App\Http\Requests\StoreLibraryRequest;
use App\Http\Requests\UpdateLibraryRequest;
use Carbon\Carbon;
use Flow\Config;
use Flow\File;
use Grimm\LibraryBook;
use Illuminate\Support\Facades\Input;


class LibraryBooksController extends Controller
{

    use AnalyzesEntity, FiltersEntity;

    /**
     * Display a listing of the resource.
     *
     * @param IndexLibraryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexLibraryRequest $request)
    {
        $books = LibraryBook::query();

        $this->filter($books);

        $this->preparePrefixDisplay($request->get('prefix'), LibraryBook::prefixesOfLength('title', 2)->get());

        $books = $this->prepareCollection('last_person_index', $books, $request, 200);

        return view('librarybooks.index', compact('books'));
    }

    /**
     * @param IndexLibraryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function analyzeBooks(IndexLibraryRequest $request)
    {
        $books = LibraryBook::query();

        $this->filter($books);

        $this->analyze($books);

        $books = $this->prepareCollection('last_person_index', $books, $request, 200);

        return view('librarybooks.analyze', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('librarybooks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLibraryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLibraryRequest $request)
    {
        $book = $request->persist();

        event(new StoreLibraryEvent($book, $request->user()));

        return redirect()
            ->route('librarybooks.show', ['id' => $book->id])
            ->with('success', trans('librarybooks.store_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param ShowLibraryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowLibraryRequest $request, $id)
    {
        $book = LibraryBook::withTrashed()->with([
            'authors',
            'editors',
            'translators',
            'illustrators'
        ])->findOrFail($id);

        return view('librarybooks.show', compact('book'));
    }


    public function export(IndexLibraryRequest $request)
    {
        $books = LibraryBook::query();

        $this->filter($books);

        $books = $this->prepareCollection('excel', $books, $request, PHP_INT_MAX);

        $excel = new Excel();

        $file = $excel->title('Books by catalog', 0)
            ->load($books->items(), 0, true)
            ->save('library-books-' . Carbon::now()->format('Ymdhis'), true);

        if ($file === null) {
            return redirect()
                ->back()
                ->with('error', 'Export konnte nicht erstellt werden!');
        }

        return response()->download($file);
    }

    public function uploadGet(IndexLibraryRequest $request, $id)
    {
        $book = LibraryBook::query()->findOrFail($id);

        $file = $this->initFlowFile();

        if ($file->checkChunk()) {
            return $this->saveUploadedFile($file, $book);
        } else {
            return response("No Content", 204);
        }
    }

    public function uploadPost(IndexLibraryRequest $request, $id)
    {
        $book = LibraryBook::query()->findOrFail($id);

        $file = $this->initFlowFile();

        if ($file->validateChunk()) {
            $file->saveChunk();

            return $this->saveUploadedFile($file, $book);
        } else {
            return response("Bad Request", 400);
        }
    }

    /**
     * @param File $file
     * @param LibraryBook $book
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Flow\FileLockException
     * @throws \Flow\FileOpenException
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     */
    private function saveUploadedFile(File $file, LibraryBook $book)
    {
        $filename = Input::get('flowRelativePath');

        $path = storage_path() . '/uploads/librarybooks/' . $book->id . '/scans/';

        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }

        if ($file->validateFile() && $file->save($path . $filename)) {
            $book->addMedia($path . $filename)
                ->toMediaCollection('librarybooks.scans');

            return response("Complete", 200);
        } else {
            return response("Ok", 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLibraryRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLibraryRequest $request, $id)
    {
        /** @var LibraryBook $book */
        $book = LibraryBook::query()->findOrFail($id);

        $request->persist($book);

        event(new UpdateLibraryEvent($book, $request->user()));

        return redirect()
            ->route('librarybooks.show', ['id' => $book->id])
            ->with('success', 'Die Änderungen wurden gespeichert');
    }

    /**
     * @param LibraryBook $book
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function relation(LibraryBook $book, $name)
    {
        return view('librarybooks.relation', compact('name', 'book'));
    }

    /**
     * @param StoreLibraryRelationRequest $request
     * @param LibraryBook $book
     * @param $relation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRelation(StoreLibraryRelationRequest $request, LibraryBook $book, $relation)
    {
        $request->persist($book, $relation);

        // TODO: trigger event

        return redirect()
            ->route('librarybooks.show', [$book])
            ->with('success', 'Verknüpfung wurde erstellt');
    }

    public function deleteRelation(DestroyLibraryRelationRequest $request, LibraryBook $book, $relation)
    {
        $request->persist($book, $relation);

        event(
            new DestroyLibraryRelationEvent($book, $request->user())
        );

        return response()->json([
            'status' => 'ok'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLibraryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyLibraryRequest $request, $id)
    {
        /** @var LibraryBook $book */
        $book = LibraryBook::query()->findOrFail($id);

        $request->persist($book);

        event(new DestroyLibraryEvent($book, $request->user()));

        return redirect()
            ->route('librarybooks.index')
            ->with('success', trans('librarybooks.deleted_success'));
    }

    /**
     * @param DestroyLibraryRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(DestroyLibraryRequest $request, $id)
    {
        /** @var LibraryBook $book */
        $book = LibraryBook::onlyTrashed()->findOrFail($id);

        $book->restore();

        return redirect()
            ->route('library.show', [$id])
            ->with('success', 'Das Buch wurde wiederhergestellt!');
    }

    protected function analyzers()
    {
        return [
            new PublishingDataAnalyzer(),
            new NotesFromJacobAnalyzer(),
            new NotesFromWilhelmAnalyzer(),
            new PurchaseNumberAnalyzer(),
        ];
    }

    protected function filters()
    {
        return [
            new TitleFilter(),
            new BookNoFilter(),
            new PrefixFilter('title'),
            new DeneckeFilter(),
            new FolkFilter(),
            new OnlyTrashedFilter('library'),
            new SortFilter(function ($builder, $orderByKey, $direction) {
                $builder->orderByRaw('ABS(catalog_id) ' . $direction)
                    ->orderBy('catalog_id', $direction);

                return 'cat_id';
            }),
        ];
    }

    /**
     * @return File
     */
    private function initFlowFile()
    {
        $config = new Config();

        if (!is_dir(storage_path() . '/uploads/temp/')) {
            mkdir(storage_path() . '/uploads/temp/', 0775, true);
        }

        $config->setTempDir(storage_path() . '/uploads/temp/');

        return new File($config);
    }
}
