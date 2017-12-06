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

namespace Discodian\Extend\Concerns;

use Discodian\Extend\Message;
use Discodian\Extend\Responses\Response;

interface AnswersMessages
{
    public function whenMentioned(): bool;

    public function respond(Message $message): ?Response;
}
