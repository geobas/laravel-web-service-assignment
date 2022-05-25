<?php

namespace App\Providers;

use App\Models\Article as ArticleModel;
use App\Models\Comment as CommentModel;
use Illuminate\Support\ServiceProvider;
use App\Services\Article as ArticleService;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\Comment as CommentResource;
use App\Repositories\Article as ArticleRepository;
use App\Repositories\Comment as CommentRepository;
use App\Contracts\Service\Article as ArticleServiceContract;
use App\Contracts\Repository\Comment as CommentRepositoryContract;
use App\Services\SynchronizeArticleExternal as SynchronizeArticleExternalService;
use App\Contracts\Service\SynchronizeArticle as SynchronizeArticleServiceContract;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ArticleServiceContract::class, function() {
            return new ArticleService(
                new ArticleRepository(new ArticleModel),
                new ArticleResource(collect()),
                new SynchronizeArticleExternalService,
            );
        });

        $this->app->singleton(CommentRepositoryContract::class, function() {
            return new CommentRepository(
                new CommentModel,
                new CommentResource(collect()),
            );
        });

        $this->app->singleton(SynchronizeArticleServiceContract::class, SynchronizeArticleExternalService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
