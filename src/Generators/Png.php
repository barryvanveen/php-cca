<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Generators;

use Barryvanveen\CCA\Interfaces\ConfigInterface;
use Barryvanveen\CCA\State;

class Png extends Image
{
    public static function createFromState(ConfigInterface $config, State $state)
    {
        return new self($config, $state);
    }

    public function save(string $destination = 'image.png')
    {
        imagetruecolortopalette($this->image, false, $this->config->states());

        return imagepng($this->image, $destination);
    }
}
