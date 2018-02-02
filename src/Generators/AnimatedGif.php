<?php

namespace Barryvanveen\CCA\Generators;

use Barryvanveen\CCA\State;
use Exception;
use GifCreator\AnimGif;

class AnimatedGif
{
    /** @var AnimGif */
    protected $animation;

    /**
     * @param State[] $states
     *
     * @throws Exception
     */
    protected function __construct(array $states)
    {
        $images = [];

        foreach ($states as $state) {
            $images[] = Gif::createFromState($state)->get();
        }

        $this->animation = new AnimGif();
        $this->animation->create($images);
    }

    public static function createFromStates(array $states)
    {
        return new self($states);
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
