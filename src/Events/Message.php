<?php

namespace Discodian\Extend\Events;

use Discodian\Extend\Messages\Message as ReceivedMessage;

class Message
{
    /**
     * @var ReceivedMessage
     */
    public $message;

    public function __construct(ReceivedMessage $message)
    {
        $this->message = $message;
    }
}
