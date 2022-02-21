<?php

namespace App\Services;

use DB;
use Log;
use Throwable;
use App\Models\Article as ArticleModel;
use App\Http\Resources\Article as ArticleResource;
use App\Contracts\Service\Article as ArticleServiceContract;
use App\Exceptions\ExternalService as ExternalServiceException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Contracts\Repository\Article as ArticleRepositoryContract;
use App\Contracts\Service\SynchronizeArticle as SynchronizeArticleServiceContract;

/**
 * Service to abstract retrieval & persistence logic of Article model.
 */
class Article implements ArticleServiceContract
{
    /**
     * Create a new service instance.
     *
     * @param \App\Contracts\Repository\Article  $repository
     * @param \App\Http\Resources\Article  $resource
     * @param \App\Contracts\Service\SynchronizeArticle  $syncArticleService
     */
    public function __construct(
        protected ArticleRepositoryContract $repository,
        protected ArticleResource $resource,
        protected SynchronizeArticleServiceContract $syncArticleService,
    ) {
    }

    public function index(): AnonymousResourceCollection|bool
    {
        try {
            return $this->resource->collection($this->repository->index());
        } catch (Throwable $t) {
            $this->logErrorAndThrow($t);

            return true;
        }
    }

    public function show(ArticleModel $article): ArticleResource|bool
    {
        try {
            return $this->resource->make($this->repository->show($article));
        } catch (Throwable $t) {
            $this->logErrorAndThrow($t);

            return true;
        }
    }

    public function store(array $data): ArticleResource|bool
    {
        DB::beginTransaction();

        try {
            $article = $this->resource->make($this->repository->store($data));

            $response = $this->syncArticleService->create($article);

            if (! $response) {
                throw new ExternalServiceException('Article synchronization error.');
            }

            DB::commit();

            return $article;
        } catch (Throwable $t) {
            DB::rollback();

            $this->logErrorAndThrow($t);

            return true;
        }
    }

    public function update(ArticleModel $article, array $data): ArticleResource|bool
    {
        DB::beginTransaction();

        try {
            $article = $this->resource->make($this->repository->update($article, $data));

            $response = $this->syncArticleService->update($article);

            if (! $response) {
                throw new ExternalServiceException('Article synchronization error.');
            }

            DB::commit();

            return $article;
        } catch (Throwable $t) {
            DB::rollback();

            $this->logErrorAndThrow($t);

            return true;
        }
    }

    public function destroy(ArticleModel $article): ArticleResource|bool
    {
        DB::beginTransaction();

        try {
            $article = $this->resource->make($this->repository->destroy($article));

            $response = $this->syncArticleService->delete($article);

            if (! $response) {
                throw new ExternalServiceException('Article synchronization error.');
            }

            DB::commit();

            return $article;
        } catch (Throwable $t) {
            DB::rollback();

            $this->logErrorAndThrow($t);

            return true;
        }
    }

    /**
     * Log error.
     *
     * @param  Throwable  $t
     * @return void
     *
     * @throws \Exception|\Error
     */
    protected function logErrorAndThrow(Throwable $t): void
    {
        Log::error("'" . $t->getMessage() . "' - File: '" . $t->getFile() . "' - Method: '"
            . debug_backtrace()[1]['function'] . "' at line: " . $t->getLine());

        throw $t;
    }
}
