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
