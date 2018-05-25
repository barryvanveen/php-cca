<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Generators;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\State;

class Gif extends Image
{
    public static function createFromState(Config $config, State $state)
    {
        return new self($config, $state);
    }

    public function save(string $destination = 'image.gif')
    {
        imagetruecolortopalette($this->image, false, $this->config->states());

        return imagegif($this->image, $destination);
    }
}
