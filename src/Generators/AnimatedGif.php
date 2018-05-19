<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Generators;

use Barryvanveen\CCA\Interfaces\ConfigInterface;
use Barryvanveen\CCA\State;
use GifCreator\AnimGif;

class AnimatedGif
{
    /** @var AnimGif */
    protected $animation;

    /**
     * @param ConfigInterface $config
     * @param State[] $states
     *
     * @throws \Exception
     */
    protected function __construct(ConfigInterface $config, array $states)
    {
        $images = [];

        foreach ($states as $state) {
            $images[] = Gif::createFromState($config, $state)->get();
        }

        $this->animation = new AnimGif();
        $this->animation->create($images);
    }

    /**
     * @param ConfigInterface $config
     * @param State[] $states
     *
     * @return AnimatedGif
     *
     * @throws \Exception
     */
    public static function createFromStates(ConfigInterface $config, array $states)
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
