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

use Discodian\Parts\Channel\Message as Part;

/**
 * {@inheritdoc}
 * @property bool $private
 * @property bool $mentionsMe
 * @property bool $mine
 */
abstract class Message extends Part
{
    public static function fromPart(Part $part): Message
    {
        return new static($part->attributes);
    }
}
