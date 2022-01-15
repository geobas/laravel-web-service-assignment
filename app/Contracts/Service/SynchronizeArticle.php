<?php

namespace App\Contracts\Service;

use App\Http\Resources\Article as ArticleResource;

/**
 * Specify a set of methods to synchronize Articles with an external service.
 */
interface SynchronizeArticle
{
    /**
     * Send all existing Articles.
     *
     * @return bool
     */
    public function sendAll(): bool;

    /**
     * Send a newly created Article.
     *
     * @param  \App\Http\Resources\Article  $article
     * @return bool
     */
    public function create(ArticleResource $article): bool;

    /**
     * Send an updated Article.
     *
     * @param  \App\Http\Resources\Article  $article
     * @return bool
     */
    public function update(ArticleResource $article): bool;

    /**
     * Send a deleted Article.
     *
     * @param  \App\Http\Resources\Article  $article
     * @return bool
     */
    public function delete(ArticleResource $article): bool;
}
