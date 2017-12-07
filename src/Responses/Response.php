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

abstract class Response
{
    /**
     * Answer privately.
     *
     * @var bool
     */
    protected $private = false;

    /**
     * The content of the reply.
     *
     * @var string|null
     */
    protected $content;

    public function privately()
    {
        $this->private = true;
        return $this;
    }

    public function openly()
    {
        $this->private = false;
        return $this;
    }

    public function with(string $content = null)
    {
        $this->content = $content;
        return $this;
    }
}
