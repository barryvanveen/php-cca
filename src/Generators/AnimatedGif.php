<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Generators;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\State;
use GifCreator\AnimGif;

class AnimatedGif
{
    /** @var AnimGif */
    protected $animation;

    /**
     * @param Config $config
     * @param State[] $states
     */
    protected function __construct(Config $config, array $states)
    {
        $images = [];

        foreach ($states as $state) {
            $images[] = Gif::createFromState($config, $state)->get();
        }

        $this->animation = new AnimGif();
        $this->animation->create($images);
    }

    /**
     * @param Config $config
     * @param State[] $states
     *
     * @return AnimatedGif
     */
    public static function createFromStates(Config $config, array $states)
    {
        return new self($config, $states);
    }

    public function get(): AnimGif
    {
        return $this->animation;
    }

    public function save(string $filename)
    {
        return $this->animation->save($filename);
    }
}
