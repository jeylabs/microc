<?php


namespace Jeylabs\Vendee;

use Illuminate\Support\ServiceProvider as LumenServiceProvider;
use Jeylabs\Vendee\Contracts\ClientServiceInterface;
use Jeylabs\Vendee\Services\ClientService;

class ServiceProvider extends LumenServiceProvider
{
    public function boot()
    {
        $source = __DIR__ . '/config/vendee.php';
        $this->app->configure('vendee');
        $this->mergeConfigFrom($source, 'vendee');
    }
    
    public function register()
    {
        $this->app->bind(ClientServiceInterface::class, function () {
            $baseUrl = config('vendee.base_url');
            return new ClientService($baseUrl);
        });
    }
}