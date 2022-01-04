<?php

namespace App\Repositories;

use App\Exceptions\CrudException;
use App\Models\Article as ArticleModel;
use Illuminate\Database\QueryException;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Contracts\Repository\Article as ArticleRepositoryContract;

class Article implements ArticleRepositoryContract
{
    /**
     * Number of items that should displayed 'per page'.
     *
     * @var int
     */
    const ITEMS_PER_PAGE = 100;

    /**
     * Create a new repository instance.
     *
     * @param \App\Models\Article  $model
     * @param \App\Http\Resources\Article  $resource
     */
    public function __construct(
        protected ArticleModel $model,
        protected ArticleResource $resource,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        try {
            return $this->resource->collection($this->model->simplePaginate(self::ITEMS_PER_PAGE));
        } catch (QueryException $e) {
            throw new CrudException($e->getMessage());
        }
    }

    public function store(): ArticleResource
    {
        try {            
            return $this->resource->make($this->model->create(request()->all()));
        } catch (QueryException $e) {
            throw new CrudException($e->getMessage());
        }
    }

    public function show(ArticleModel $article): ArticleResource
    {
        return $this->resource->make($article);
    }

    public function update(ArticleModel $article): ArticleResource
    {
        try {
            return $this->resource->make(tap($article)->update(request()->all()));
        } catch (QueryException $e) {
            throw new CrudException($e->getMessage());
        }
    }

    public function destroy(ArticleModel $article): ArticleResource
    {        
        try {                        
            return $this->resource->make(tap($article)->delete());
        } catch (QueryException $e) {
            throw new CrudException($e->getMessage());
        }        
    }
}
