<?php

namespace Discodian\Extend;

use Discodian\Parts\Channel\Message as Part;

class Message extends Part
{
    public static function fromPart(Part $part): Message
    {
        return new Message($part->attributes);
    }
}
