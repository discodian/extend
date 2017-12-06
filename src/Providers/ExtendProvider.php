<?php

namespace Discodian\Extend\Providers;

use Discodian\Extend\Listeners\ProxiesMessages;
use Illuminate\Support\ServiceProvider;

class ExtendProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['events']->subscribe(ProxiesMessages::class);
    }
}
