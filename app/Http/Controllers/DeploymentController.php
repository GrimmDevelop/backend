<?php

namespace App\Http\Controllers;

use App\Deployment\DeploymentService;
use App\Deployment\ElasticIndexService;
use App\Jobs\UpdateElasticsearchIndex;
use Carbon\Carbon;
use Grimm\Book;
use Grimm\LibraryBook;
use Grimm\Person;

class DeploymentController extends Controller
{

    /**
     * @param DeploymentService $deployment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(DeploymentService $deployment)
    {
        $this->authorize('admin.deployment');

        return view('admin.deployment.index', compact('deployment'));
    }

    /**
     * @param DeploymentService $deployment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function triggerDeployment(DeploymentService $deployment)
    {
        $this->authorize('admin.deployment');

        if ($deployment->inProgress()) {
            abort(503);
        }

        $deployment->setInProgress();

        $this->dispatch(new UpdateElasticsearchIndex(Carbon::now(), auth()->user()));

        return response()->json([
            'data' => [
                'action' => 'ok',
                'books' => Book::count(),
                'people' => Person::count(),
                'libraryBooks' => LibraryBook::count()
            ]
        ]);
    }

    /**
     * @param ElasticIndexService $indexService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function blankify(ElasticIndexService $indexService)
    {
        $this->authorize('admin.deployment');

        $indexService->dropIndex('grimm');

        // We have to still create the index to prevent API errors
        $indexService->createIndex('grimm', $indexService->mappingsFromProvider());

        return response()->json(['data' => ['action' => 'ok', 'message' => 'Der Index wurde geleert']]);
    }

    /**
     * @param DeploymentService $deployment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function status(DeploymentService $deployment)
    {
        $this->authorize('admin.deployment');

        return response()->json(['data' => $deployment->status()]);
    }
}
