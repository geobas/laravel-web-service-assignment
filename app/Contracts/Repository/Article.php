<?php

namespace App\Contracts\Repository;

use App\Models\Article as ArticleModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Specify a set of repository methods for Article retrieval & persistence.
 */
interface Article
{
    /**
     * Get all Articles.
     *
     * @return \Illuminate\Pagination\Paginator
     *
     * @throws \App\Exceptions\CrudException
     */
    public function index(): Paginator;

    /**
     * Save a new Article.
     *
     * @param  array  $data
     * @return \App\Models\Article
     *
     * @throws \App\Exceptions\CrudException
     */
    public function store(array $data): ArticleModel;

    /**
     * Get one Article.
     *
     * @param  \App\Models\Article  $article
     * @return \App\Models\Article
     */
    public function show(ArticleModel $article): ArticleModel;

    /**
     * Edit an Article.
     *
     * @param  \App\Models\Article  $article
     * @param  array  $data
     * @return \App\Models\Article
     *
     * @throws \App\Exceptions\CrudException
     */
    public function update(ArticleModel $article, array $data): ArticleModel;

    /**
     * Delete an Article.
     *
     * @param  \App\Models\Article  $article
     * @return \App\Models\Article
     *
     * @throws \App\Exceptions\CrudException
     */
    public function destroy(ArticleModel $article): ArticleModel;
}
