<?php

namespace App\Http\Controllers;

use DB;
use Throwable;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Helpers\HttpStatus as Status;
use App\Http\Requests\Article as ArticleRequest;
use App\Exceptions\ExternalService as ExternalServiceException;
use App\Contracts\Repository\Article as ArticleRepositoryContract;
use App\Contracts\Service\SynchronizeArticle as SynchronizeArticleServiceContract;

/**
 * Controller to handle all requests regarding Articles.
 */
class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \App\Contracts\Repository\Article  $repository
     * @param \App\Contracts\Service\SynchronizeArticle  $syncArticleService
     */
    public function __construct(
        protected ArticleRepositoryContract $repository,
        protected SynchronizeArticleServiceContract $syncArticleService,
    ) {}

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
        try {
            return response()->api(
                $this->repository->index($request)->resource
            , Status::OK);
        } catch (Throwable $t) {
            $this->logErrorAndThrow($t);
        }
    }

    /**
     * Store a newly created resource in storage
     * and sync it to the external service.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     * 
     * @param  \App\Http\Requests\Article  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \App\Exceptions\ExternalService
     */
    public function store(ArticleRequest $request)
    {
        DB::beginTransaction();

        try {
            $article = $this->repository->store($request);

            $response = $this->syncArticleService->create($article);

            if (!$response) {
                throw new ExternalServiceException('Article synchronization error.');
            }
            
            DB::commit();

            return response()->api([
                'data' => $article
            ], Status::CREATED);
        } catch (Throwable $t) {
            DB::rollback();

            $this->logErrorAndThrow($t);
        }
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
        try {
            return response()->api([
                'data' => $this->repository->show($article)
            ], Status::OK);
        } catch (Throwable $t) {
            $this->logErrorAndThrow($t);
        }       
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
     *
     * @throws \App\Exceptions\ExternalService
     */
    public function update(ArticleRequest $request, Article $article)
    {
        DB::beginTransaction();

        try {
            $article = $this->repository->update($article);

            $response = $this->syncArticleService->update($article);

            if (!$response) {
                throw new ExternalServiceException('Article synchronization error.');
            }

            DB::commit();

            return response()->api([
                'data' => $article
            ], Status::OK);
        } catch (Throwable $t) {
            DB::rollback();

            $this->logErrorAndThrow($t);
        }  
    }

    /**
     * Remove the specified resource from storage
     * and sync it to the external service.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     * 
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \App\Exceptions\ExternalService
     */
    public function destroy(Article $article)
    {
        DB::beginTransaction();

        try {
            $article = $this->repository->destroy($article);

            $response = $this->syncArticleService->delete($article);

            if (!$response) {
                throw new ExternalServiceException('Article synchronization error.');
            }

            DB::commit();

            return response()->api([
                'data' => $article
            ], Status::OK);
        } catch (Throwable $t) {
            DB::rollback();

            $this->logErrorAndThrow($t);
        }
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
            'message' => 'All Articles were synchronized.'
        ], Status::OK);
    }
}
