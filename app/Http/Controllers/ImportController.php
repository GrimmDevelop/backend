<?php

namespace App\Http\Controllers;

use App\Import\ImportService;
use App\Jobs\ImportDBFDatabases;
use Flow\Config;
use Flow\File;

class ImportController extends Controller
{

    /**
     * @param ImportService $import
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(ImportService $import)
    {
        $this->authorize('admin.import');

        return view('admin.import.index', compact('import'));
    }

    /**
     * @param ImportService $import
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(ImportService $import)
    {
        $file = request()->get('file');

        if (!$import->getDatabaseNames()->contains($file)) {
            return redirect()
                ->back()
                ->with('error', 'Ungültige Datenbank');
        }

        unlink(storage_path('import/') . $file);

        return redirect()
            ->back()
            ->with('success', 'Die Datenbank wurde entfernt und wird nicht importiert');
    }

    /**
     * @param ImportService $import
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function status(ImportService $import)
    {
        $this->authorize('admin.import');

        return response()->json(['data' => $import->status()]);
    }

    /**
     * @param ImportService $import
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function trigger(ImportService $import)
    {
        $this->authorize('admin.import');

        if ($import->inProgress()) {
            abort(503);
        }

        $import->setInProgress();

        $this->dispatch(new ImportDBFDatabases(auth()->user()));

        return response()->json([
            'data' => [
                'action' => 'ok',
                'letters' => 0,
                'people' => 0,
                'books' => 0,
            ]
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Flow\FileLockException
     * @throws \Flow\FileOpenException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function uploadGet()
    {
        $this->authorize('admin.import');

        $file = $this->initFlowFile();

        if ($file->checkChunk()) {
            return $this->saveUploadedFile($file);
        } else {
            return response("No Content", 204);
        }
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Flow\FileLockException
     * @throws \Flow\FileOpenException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function uploadPost()
    {
        $this->authorize('admin.import');

        $file = $this->initFlowFile();

        if ($file->validateChunk()) {
            $file->saveChunk();

            return $this->saveUploadedFile($file);
        } else {
            return response("Bad Request", 400);
        }
    }

    /**
     * @param File $file
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Flow\FileLockException
     * @throws \Flow\FileOpenException
     */
    private function saveUploadedFile(File $file)
    {
        $filename = request()->get('flowRelativePath');

        $path = storage_path() . '/import/';

        if ($file->validateFile() && $file->save($path . $filename)) {
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

        if (!is_dir(storage_path() . '/import/temp/')) {
            mkdir(storage_path() . '/import/temp/', 0775, true);
        }

        $config->setTempDir(storage_path() . '/import/temp/');

        return new File($config);
    }
}
