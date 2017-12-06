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
use Discodian\Extend\Messages;
use Discodian\Parts\Channel\Channel;
use Discodian\Parts\Channel\Message as Part;
use Illuminate\Contracts\Events\Dispatcher;

class ProxiesMessages
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Set::class, [$this, 'proxy']);
    }

    public function proxy(Set $event)
    {
        if ($event->part instanceof Part) {
            if ($event->part->channel->type === Channel::TYPE_DM) {
                $message = Messages\DirectMessage::fromPart($event->part);
            }
            if ($event->part->channel->type === Channel::TYPE_GROUP) {
                $message = Messages\GroupMessage::fromPart($event->part);
            }
            if ($event->part->channel->type === Channel::TYPE_VOICE) {
                $message = Messages\VoiceChannelMessage::fromPart($event->part);
            }
            if ($event->part->channel->type === Channel::TYPE_TEXT) {
                $message = Messages\TextChannelMessage::fromPart($event->part);
            }
        }
    }
}
