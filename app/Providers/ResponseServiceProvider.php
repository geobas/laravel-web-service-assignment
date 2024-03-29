<?php

namespace App\Providers;

use App\Helpers\HttpStatus as Status;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap service.
     *
     * @return void
     */
    public function boot()
    {
        response()->macro('api', function($data, $status = Status::OK) {
            return response()->json($data ?? [], $status, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
