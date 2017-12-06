<?php

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
