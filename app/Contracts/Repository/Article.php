<?php

namespace App\Contracts\Repository;

use App\Models\Article as ArticleModel;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Specify a set of repository methods for Article retrieval & persistence.
 */
interface Article
{
    /**
     * Get all Articles.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \App\Exceptions\CrudException
     */
    public function index(): AnonymousResourceCollection;

    /**
     * Save a new Article.
     *
     * @return \App\Http\Resources\Article
     *
     * @throws \App\Exceptions\CrudException
     */
    public function store(): ArticleResource;

    /**
     * Get one Article.
     *
     * @param  \App\Models\Article  $article
     * @return \App\Http\Resources\Article
     */
    public function show(ArticleModel $article): ArticleResource;

    /**
     * Edit an Article.
     *
     * @param  \App\Models\Article  $article
     * @return \App\Http\Resources\Article
     *
     * @throws \App\Exceptions\CrudException
     */
    public function update(ArticleModel $article): ArticleResource;

    /**
     * Delete an Article.
     *
     * @param  \App\Models\Article  $article
     * @return \App\Http\Resources\Article
     *
     * @throws \App\Exceptions\CrudException
     */
    public function destroy(ArticleModel $article): ArticleResource;
}
