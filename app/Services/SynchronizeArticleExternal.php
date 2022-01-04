<?php

namespace App\Services;

use Carbon\Carbon;
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
     * Base url of external service.
     *
     * @var string
     */
    const BASE_URL = 'https://lapi.external-services.com/v2/';

    /**
     * Bearer token.
     *
     * @var string
     */
    const TOKEN = 'my-unique_token-12';

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
    public function __construct() {
        $this->client = Http::fake()->accept('application/vnd.api+json')->withToken(self::TOKEN);
    }

    public function sendAll(): bool
    {
        $failed = false;

        Article::chunk(self::SIZE, function ($articles) use (&$failed) {
            $articles->each(function($article) use (&$failed) {
                if (!$this->create(ArticleResource::make($article))) {
                    $failed = true;

                    return false;
                }
            });
        });

        return !$failed;
    }

    public function create(ArticleResource $article): bool
    {
        return $this->client
                    ->post(self::BASE_URL . 'articles', [
                        'type' => 'article',
                        'attributes' => [
                            'title' => $article->title,
                            'content' => $article->content,
                            'category' => $article->category,
                            'date' => Carbon::createFromDate($article->created_at)->format('d-m-Y H:i:s'),
                            'uuid' => $article->uuid,
                        ]
                    ])
                    ->successful();
    }

    public function update(ArticleResource $article): bool
    {
        return $this->client
                    ->put(self::BASE_URL . "articles/{$article->id}", [
                        'id' => $article->id,
                        'type' => 'article',
                        'attributes' => [
                            'title' => $article->title,
                            'content' => $article->content,
                            'category' => $article->category,
                            'date' => Carbon::createFromDate($article->created_at)->format('d-m-Y H:i:s'),
                            'uuid' => $article->uuid,
                        ]
                    ])
                    ->successful();
    }

    public function delete(ArticleResource $article): bool
    {
        return $this->client
                    ->delete(self::BASE_URL . "articles/{$article->id}")
                    ->successful();
    }
}
