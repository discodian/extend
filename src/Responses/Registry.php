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

namespace Discodian\Extend\Responses;

use Discodian\Extend\Concerns\ReadsMessages;
use Discodian\Extend\Exceptions\InvalidListenerException;
use Discodian\Parts\Bot;
use Illuminate\Support\Collection;

class Registry
{
    /**
     * @var Bot
     */
    protected $bot;

    /**
     * The message listeners.
     *
     * @var Collection
     */
    protected $listeners;

    public function __construct(Bot $bot)
    {
        $this->bot = $bot;
        $this->listeners = new Collection();
    }

    public function add(string $listener)
    {
        if (!in_array(ReadsMessages::class, class_implements($listener))) {
            throw new InvalidListenerException($listener);
        }

        $this->listeners = $this->listeners->push($listener)->unique();

        return $this;
    }

    public function get(): Collection
    {
        return $this->listeners;
    }
}
