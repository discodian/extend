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

namespace Discodian\Extend\Responses;

use Discodian\Parts\Guild\Embed;

class TextResponse extends Response
{

    /**
     * Send response as text to speech.
     *
     * @var bool
     */
    protected $tts = false;

    /**
     * Add an embed.
     *
     * @var Embed
     */
    protected $embed;

    public function tts(bool $tts = true)
    {
        $this->tts = $tts;
        return $this;
    }

    public function embed(Embed $embed = null)
    {
        $this->embed = $embed;
        return $this;
    }
}
