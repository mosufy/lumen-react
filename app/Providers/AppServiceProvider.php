<?php

namespace App\Providers;

use App\Services\ElasticsearchService;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register the ElasticsearchService
        $this->app->bind(ElasticsearchService::class, function () {
            return new ElasticsearchService(ClientBuilder::create()->build());
        });
    }
}
