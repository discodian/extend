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

namespace Discodian\Extend;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Manager
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Collection
     */
    protected $extensions;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function extensions(): Collection
    {
        if (!$this->extensions) {
            $path = $this->app->basePath() . '/vendor/composer/installed.json';

            $this->extensions = collect(file_exists($path) ? json_decode(file_get_contents($path), true) : [])
                ->filter(function (array $package) {
                    return Arr::get($package, 'type') === 'discodian-extension';
                })
                ->mapWithKeys(function (array $package) {
                    $extension = Extension::new($package);
                    $extension->path = $this->app->basePath() . '/vendor/' . $extension->name;

                    return [
                        $extension->name => $extension
                    ];
                });
        }

        return $this->extensions;
    }

    public function boot()
    {
        $this->extensions()
            ->filter(function (Extension $extension) {
                return $extension->hasBootstrapper();
            })
            ->each(function (Extension $extension) {
                $bootstrapper = $extension->bootstrapper();
                $this->app->call(require $bootstrapper);
                logs("Bootstrapped extension {$extension->name}.");
            });
    }
}
