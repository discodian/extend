<?php

namespace Discodian\Extend\Messages;

use Discodian\Extend\Responses\Response;
use Discodian\Parts\Channel\Message as Part;

abstract class Message
{
    public $private = false;

    public static function fromPart(Part $part): Message
    {
        return new static($part->attributes);
    }

    public function respond(Response $response)
    {

    }
}
