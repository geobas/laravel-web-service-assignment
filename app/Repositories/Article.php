<?php

namespace App\Repositories;

use App\Exceptions\CrudException;
use Illuminate\Pagination\Paginator;
use App\Models\Article as ArticleModel;
use Illuminate\Database\QueryException;
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
     */
    public function __construct(
        protected ArticleModel $model,
    ) {
    }

    public function index(): Paginator
    {
        try {
            return $this->model->simplePaginate(self::ITEMS_PER_PAGE);
        } catch (QueryException $e) {
            throw new CrudException($e->getMessage());
        }
    }

    public function store(array $data): ArticleModel
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {
            throw new CrudException($e->getMessage());
        }
    }

    public function show(ArticleModel $article): ArticleModel
    {
        return $article;
    }

    public function update(ArticleModel $article, array $data): ArticleModel
    {
        try {
            return tap($article)->update($data);
        } catch (QueryException $e) {
            throw new CrudException($e->getMessage());
        }
    }

    public function destroy(ArticleModel $article): ArticleModel
    {
        try {
            return tap($article)->delete();
        } catch (QueryException $e) {
            throw new CrudException($e->getMessage());
        }
    }
}
