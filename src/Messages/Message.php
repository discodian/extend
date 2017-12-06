<?php

namespace Discodian\Extend\Messages;

abstract class Message
{
    public $private = false;

    public static function fromPart(Part $part): Message
    {
        return new static($part->attributes);
    }
}
