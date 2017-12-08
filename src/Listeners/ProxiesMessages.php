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
use Discodian\Core\Response\Handler;
use Discodian\Extend\Concerns\AnswersMessages;
use Discodian\Extend\Concerns\ReadsMessages;
use Discodian\Extend\Events\Message as Event;
use Discodian\Extend\Messages\Factory;
use Discodian\Extend\Messages\Message;
use Discodian\Extend\Responses\Registry;
use Discodian\Extend\Responses\Response;
use Discodian\Parts\Channel\Message as Part;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Str;
use React\Promise\Promise;
use function React\Promise\all;

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
    /**
     * @var Handler
     */
    private $respond;

    public function __construct(Dispatcher $events, Factory $factory, Handler $respond)
    {
        $this->events = $events;
        $this->factory = $factory;
        $this->respond = $respond;
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(Set::class, [$this, 'proxy']);
    }

    public function proxy(Set $event)
    {
        if ($event->part instanceof Part) {
            $message = $this->factory->create($event->part);

            if ($message->mine) {
                return;
            }

            logs("Distributing to response registry.");

            $this->registryHandler($message);

            logs("Proxying message type " . get_class($message));

            $this->events->dispatch(new Event($message));
        }
    }

    protected function registryHandler(Message $message)
    {
        /** @var Registry $registry */
        $registry = app()->make(Registry::class);

        $promises = [];

        $registry->get()->each(function (string $listener) use ($message, &$promises) {
            /** @var ReadsMessages|AnswersMessages $listener */
            $listener = app()->make($listener);
            $options = [];

            if (!empty($listener->onChannels()) && !in_array($message->channelType, $listener->onChannels())) {
                return;
            }

            if ($listener->forPrefix() && !Str::startsWith($message->content, $listener->forPrefix())) {
                return;
            }

            if ($listener->whenMentioned() && !$message->mentionsMe) {
                return;
            }

            if ($listener->whenAddressed() && !$message->addressesMe) {
                return;
            }

            $regex = $listener->whenMessageMatches();

            if ($regex && !preg_match_all("/$regex/", $message->content, $matches)) {
                return;
            }
            if ($regex) {
                $options['matches'] = $matches;
            }

            $response = $listener->respond($message, $options);

            if ($response instanceof Response) {
                $this->respond->to($message, $response);
            }
            if ($response instanceof Promise) {
                $promises[] = $response;
            }
        });

        all($promises)
            ->done(function ($responses) use ($message) {
                logs("promises received", $responses);
                /** @var Response $response */
                foreach ($responses as $response) {
                    $this->respond->to($message, $response);
                }
            }, function ($responses) {
                logs("Resolving response promises failed.");
            });
    }
}
