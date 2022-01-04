<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Article as ArticleModel;
use App\Http\Resources\Article as ArticleResource;
use App\Repositories\Article as ArticleRepository;
use App\Contracts\Repository\Article as ArticleRepositoryContract;
use App\Contracts\Service\SynchronizeArticle as SynchronizeArticleServiceContract;
use App\Services\SynchronizeArticleExternal as SynchronizeArticleExternalService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ArticleRepositoryContract::class, function () {
            return new ArticleRepository(new ArticleModel, new ArticleResource(collect()));
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
