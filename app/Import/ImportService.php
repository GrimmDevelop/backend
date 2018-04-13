<?php

namespace App\Import;

use Spatie\Valuestore\Valuestore;

class ImportService
{

    private $lookup = [
        "letters" => "CORPUS.DBF",
        "people" => "persreg.DBF",
        "books" => "DRUCKE.DBF"
    ];

    /**
     * @var Valuestore
     */
    private $valuestore;

    public function __construct(Valuestore $valuestore)
    {
        $this->valuestore = $valuestore;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getDatabaseNames()
    {
        return collect($this->lookup);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function databases()
    {
        return $this->getDatabaseNames()
            ->filter(function ($file) {
                return file_exists(storage_path('import/') . $file);
            })
            ->map(function ($file, $key) {
                return [
                    'name' => $file,
                    'type' => $key,
                    'path' => storage_path('import/') . $file,
                    'remove' => route('admin.import.index') . '/remove?file=' . urlencode($file),
                ];
            });
    }

    /**
     * Check if there is a deployment running
     *
     * @return bool
     */
    public function inProgress()
    {
        return $this->valuestore->get('import-running', false);
    }

    public function setInProgress($status = true)
    {
        return $this->valuestore->put('import-running', $status);
    }

    /**
     * @return array
     */
    public function status()
    {
        return [
            'databases' => $this->databases(),
            'inProgress' => $this->inProgress(),
        ];
    }
}