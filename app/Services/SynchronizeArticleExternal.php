<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\Article as ArticleResource;
use App\Contracts\Service\SynchronizeArticle as SynchronizeArticleServiceContract;

/**
 * External service that synchronizes Articles when those are created, updated or deleted.
 */
class SynchronizeArticleExternal implements SynchronizeArticleServiceContract
{
    /**
     * Take elements up to the specified position.
     *
     * @var int
     */
    const SIZE = 1000;

    /**
     * Instance of HTTP Client.
     *
     * @var \Illuminate\Http\Client\PendingRequest
     */
    protected $client;

    /**
     * Create a new service instance.
     */
    public function __construct()
    {
        $this->client = Http::fake()
            ->timeout(3)
            ->accept('application/vnd.api+json')
            ->withToken(config('services.external.token'));
    }

    public function sendAll(): bool
    {
        $failed = false;

        Article::chunk(self::SIZE, function ($articles) use (&$failed) {
            $articles->each(function ($article) use (&$failed) {
                if (! $this->create(ArticleResource::make($article))) {
                    $failed = true;

                    return false;
                }
            });
        });

        return ! $failed;
    }

    public function create(ArticleResource $article): bool
    {
        return $this->client
            ->post(config('services.external.base_url') . 'articles', [
                'type' => 'article',
                'attributes' => $this->buildAttributesPaylod($article),
            ])
            ->throw()
            ->successful();
    }

    public function update(ArticleResource $article): bool
    {
        return $this->client
            ->put(config('services.external.base_url') . "articles/{$article->id}", [
                'id' => $article->id,
                'type' => 'article',
                'attributes' => $this->buildAttributesPaylod($article),
            ])
            ->throw()
            ->successful();
    }

    public function delete(ArticleResource $article): bool
    {
        return $this->client
            ->delete(config('services.external.base_url') . "articles/{$article->id}")
            ->throw()
            ->successful();
    }

    /**
     * Build common payload of 'attributes' key.
     *
     * @param  ArticleResource  $article
     * @return array
     */
    private function buildAttributesPaylod(ArticleResource $article): array
    {
        return [
            'title' => $article->title,
            'content' => $article->content,
            'category' => $article->category,
            'date' => $article->created_at->format('d-m-Y H:i:s'),
            'uuid' => $article->uuid,
        ];
    }
}
