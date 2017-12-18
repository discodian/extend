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

namespace Discodian\Extend\Messages;

use Discodian\Parts\Bot;
use Discodian\Parts\Channel\Channel;
use Discodian\Parts\Channel\Message as Part;
use Illuminate\Support\Str;

class Factory
{
    public function create(Part $part)
    {
        $bot = app(Bot::class);

        $channelType = (int) $part->channel->type;

        $message = null;
        if ($channelType === Channel::TYPE_DM) {
            $message = DirectMessage::fromPart($part);
        }
        if ($channelType === Channel::TYPE_VOICE) {
            $message = VoiceChannelMessage::fromPart($part);
        }
        if ($channelType === Channel::TYPE_GROUP) {
            $message = GroupMessage::fromPart($part);
        }

        if ($channelType === Channel::TYPE_TEXT) {
            $message = true;
        }

        if (is_null($message)) {
            logs('error', "What is channel type {$channelType}?", $part->toArray());
        }

        if (is_null($message) || $message === true) {
            $message = TextChannelMessage::fromPart($part);
        }

        if ($channelType !== Channel::TYPE_VOICE && $part->mentions) {
            $message->mentionsMe = $part->mentions->has($bot->getKey());
            $message->addressesMe = Str::startsWith($message->content, (string) $bot);
        }

        if ($message->author) {
            $message->mine = $message->author->id === $bot->id;
        }

        $message->channelType = $channelType;

        return $message;
    }
}
