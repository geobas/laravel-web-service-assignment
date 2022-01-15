<?php

namespace App\Http\Controllers;

use App;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Helpers\HttpStatus as Status;
use App\Http\Requests\Article as ArticleRequest;
use App\Contracts\Service\Article as ArticleServiceContract;
use App\Exceptions\ExternalService as ExternalServiceException;
use App\Contracts\Service\SynchronizeArticle as SynchronizeArticleServiceContract;

/**
 * Controller to handle all requests regarding Articles.
 */
class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \App\Contracts\Service\Article  $service
     * @param \App\Contracts\Service\SynchronizeArticle  $syncArticleService
     */
    public function __construct(
        protected ArticleServiceContract $service,
        protected SynchronizeArticleServiceContract $syncArticleService,
    ) {
        // App::setLocale('el');
    }

    /**
     * Display a listing of the resource.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \Illuminate\Http\Request;
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->api(
            $this->service->index()->resource,
            Status::OK
        );
    }

    /**
     * Store a newly created resource in storage
     * and sync it to the external service.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \App\Http\Requests\Article  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ArticleRequest $request)
    {
        return response()->api([
            'data' => $this->service->store($request->validated()),
        ], Status::CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Article $article)
    {
        return response()->api([
            'data' => $this->service->show($article),
        ], Status::OK);
    }

    /**
     * Update the specified resource in storage
     * and sync it to the external service.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \App\Http\Requests\Article  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ArticleRequest $request, Article $article)
    {
        return response()->api([
            'data' => $this->service->update($article, $request->validated()),
        ], Status::OK);
    }

    /**
     * Remove the specified resource from storage
     * and sync it to the external service.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Article $article)
    {
        return response()->api([
            'data' => $this->service->destroy($article),
        ], Status::OK);
    }

    /**
     * Send all existing Articles to the external service.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \App\Exceptions\ExternalService
     */
    public function sendAll()
    {
        $response = $this->syncArticleService->sendAll();

        if (!$response) {
            throw new ExternalServiceException('Article synchronization error.');
        }

        return response()->api([
            'message' => 'All Articles were synchronized.',
        ], Status::OK);
    }
}
