<?php

/*
 * This file is part of the Discodian bot toolkit.
 *
 * (c) Daniël Klabbers <daniel@klabbers.email>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see http://discodian.com
 * @see https://github.com/discodian
 */

namespace Discodian\Extend\Providers;

use Discodian\Extend\Listeners\ProxiesMessages;
use Discodian\Extend\Responses\Registry;
use Illuminate\Support\ServiceProvider;

class ExtendProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['events']->subscribe(ProxiesMessages::class);
        $this->app->singleton(Registry::class);
    }
}
