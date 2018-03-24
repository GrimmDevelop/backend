<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexLetterRequest;
use Flow\Config;
use Flow\File;
use Grimm\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Spatie\MediaLibrary\Media;

class LetterScansController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Letter $letter
     * @return \Illuminate\Http\Response
     */
    public function index(Letter $letter)
    {
        return view('letters.scans.index', compact('letter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Letter $letter
     * @param Media $scan
     * @return \Illuminate\Http\Response
     */
    public function show(Letter $letter, Media $scan)
    {
        return $scan->toResponse(request());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @param Media $scan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Letter $letter, Media $scan)
    {
        if ($request->post('left')) {
            $this->moveMediaLeft($letter, $scan);
        } else {
            if ($request->post('right')) {
                $this->moveMediaRight($letter, $scan);
            }
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $letter
     * @param Media $scan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Letter $letter, Media $scan)
    {
        try {
            $collection = $scan->collection_name;

            $scan->delete();

            $letter->resortCollection($collection);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Der Scan wurde nicht gelöscht!');
        }

        return redirect()
            ->back()
            ->with('success', 'Der Scan wurde gelöscht!');
    }

    public function uploadGet(IndexLetterRequest $request, $id)
    {
        $book = Letter::query()->findOrFail($id);

        $file = $this->initFlowFile();

        if ($file->checkChunk()) {
            return $this->saveUploadedFile($file, $book);
        } else {
            return response("No Content", 204);
        }
    }

    public function uploadPost(IndexLetterRequest $request, $id)
    {
        $book = Letter::query()->findOrFail($id);

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
     * @param Letter $letter
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Flow\FileLockException
     * @throws \Flow\FileOpenException
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     */
    private function saveUploadedFile(File $file, Letter $letter)
    {
        $filename = Input::get('flowRelativePath');

        $collection = Input::get('collection', 'default');

        $tmp = uniqid(null, true);

        $path = storage_path() . '/uploads/temp/';

        if ($file->validateFile() && $file->save($path . $tmp)) {
            $collection = 'letters.scans.' . $collection;

            $letter->addMedia($path . $tmp)
                ->usingFileName($filename)
                ->usingName($filename)
                ->toMediaCollection($collection);

            $letter->resortCollection($collection);

            return response("Complete", 200);
        } else {
            return response("Ok", 200);
        }
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

    private function moveMediaLeft(Letter $letter, Media $media)
    {
        $collection = $letter->getMedia($media->collection_name);

        $ids = [];

        $mediaIndex = null;

        foreach ($collection as $index => $item) {
            $ids[] = $item->id;

            if ($item->id == $media->id) {
                $mediaIndex = $index;
            }
        }

        if ($mediaIndex < 1) {
            return false;
        }

        $ids[$mediaIndex] = $ids[$mediaIndex - 1];

        $ids[$mediaIndex - 1] = $media->id;

        Media::setNewOrder($ids);

        return true;
    }

    private function moveMediaRight(Letter $letter, Media $media)
    {
        $collection = $letter->getMedia($media->collection_name);

        $ids = [];

        $mediaIndex = null;

        foreach ($collection as $index => $item) {
            $ids[] = $item->id;

            if ($item->id == $media->id) {
                $mediaIndex = $index;
            }
        }

        if ($mediaIndex >= count($ids) - 1) {
            return false;
        }

        $ids[$mediaIndex] = $ids[$mediaIndex + 1];

        $ids[$mediaIndex + 1] = $media->id;

        Media::setNewOrder($ids);

        return true;
    }
}
