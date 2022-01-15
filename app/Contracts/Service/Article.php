<?php

namespace App\Contracts\Service;

use App\Models\Article as ArticleModel;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Specify a set of service methods for Article retrieval & persistence.
 */
interface Article
{
    /**
     * Get all Articles.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Exception|\Error
     */
    public function index(): AnonymousResourceCollection;

    /**
     * Get one Article.
     *
     * @param  \App\Models\Article  $article
     * @return \App\Http\Resources\Article
     *
     * @throws \Exception|\Error
     */
    public function show(ArticleModel $article): ArticleResource;

    /**
     * Create a new Article.
     *
     * @param  array  $data
     * @return \App\Http\Resources\Article
     *
     * @throws \Exception|\Error|\App\Exceptions\ExternalService
     */
    public function store(array $data): ArticleResource;

    /**
     * Edit an Article.
     *
     * @param  \App\Models\Article  $article
     * @param  array  $data
     * @return \App\Http\Resources\Article
     *
     * @throws \Exception|\Error|\App\Exceptions\ExternalService
     */
    public function update(ArticleModel $article, array $data): ArticleResource;

    /**
     * Delete an Article.
     *
     * @param  \App\Models\Article  $article
     * @return \App\Http\Resources\Article
     *
     * @throws \Exception|\Error|\App\Exceptions\ExternalService
     */
    public function destroy(ArticleModel $article): ArticleResource;
}
