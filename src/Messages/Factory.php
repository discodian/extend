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
    /**
     * @var Bot
     */
    private $bot;

    public function __construct(Bot $bot)
    {
        $this->bot = $bot;
    }

    public function create(Part $part)
    {
        $channelType = $part->channel->type;

        if ($channelType === Channel::TYPE_TEXT) {
            $message = TextChannelMessage::fromPart($part);
        }
        if ($channelType === Channel::TYPE_DM) {
            $message = DirectMessage::fromPart($part);
        }
        if ($channelType === Channel::TYPE_VOICE) {
            $message = VoiceChannelMessage::fromPart($part);
        }
        if ($channelType === Channel::TYPE_GROUP) {
            $message = GroupMessage::fromPart($part);
        }

        if ($channelType !== Channel::TYPE_VOICE && $part->mentions) {
            $message->mentionsMe = $part->mentions->has($this->bot->getKey());
            $message->addressesMe = Str::startsWith($message->content, (string) $this->bot);
        }

        $message->channelType = $channelType;

        return $message;
    }
}
