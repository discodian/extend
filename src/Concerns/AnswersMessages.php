<?php

namespace Discodian\Extend\Concerns;

use Discodian\Extend\Message;
use Discodian\Extend\Responses\Response;

interface AnswersMessages
{
    public function whenMentioned(): bool;

    public function respond(Message $message): ?Response;
}
