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

namespace Discodian\Extend\Listeners;

use Discodian\Core\Events\Parts\Set;
use Discodian\Extend\Events\Message;
use Discodian\Extend\Messages\Factory;
use Discodian\Parts\Channel\Channel;
use Discodian\Parts\Channel\Message as Part;
use Illuminate\Contracts\Events\Dispatcher;

class ProxiesMessages
{
    /**
     * @var Dispatcher
     */
    private $events;
    /**
     * @var Factory
     */
    private $factory;

    public function __construct(Dispatcher $events, Factory $factory)
    {
        $this->events = $events;
        $this->factory = $factory;
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(Set::class, [$this, 'proxy']);
    }

    public function proxy(Set $event)
    {
        if ($event->part instanceof Part) {
            $message = $this->factory->create($event->part);

            logs("Proxying message type " . get_class($message));

            $this->events->dispatch(new Message($message));
        }
    }
}
