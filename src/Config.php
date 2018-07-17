<?php

declare(strict_types=1);

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Config\NeighborhoodOptions;
use Barryvanveen\CCA\Config\Options;
use Barryvanveen\CCA\Config\Validator;
use Phim\Color\RgbColor;

class Config
{
    protected $config = [
        Options::COLUMNS           => 10,
        Options::IMAGE_CELL_SIZE   => 2,
        Options::IMAGE_COLORS      => null,
        Options::IMAGE_HUE         => null,
        Options::NEIGHBORHOOD_TYPE => NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE,
        Options::NEIGHBORHOOD_SIZE => 1,
        Options::ROWS              => 10,
        Options::SEED              => null,
        Options::STATES            => 3,
        Options::THRESHOLD         => 3,
    ];

    public function __construct(array $config)
    {
        // set defaults
        $this->config[Options::IMAGE_HUE] = $this->makeHue();
        $this->config[Options::SEED] = $this->makeSeed();

        // validate config
        Validator::validate($config);

        // override defaults
        $this->config = array_merge($this->config, $config);
    }

    protected function makeHue(): int
    {
        return rand(0, 360);
    }

    protected function makeSeed(): int
    {
        list($usec, $sec) = explode(' ', microtime());

        return intval($sec + $usec * 1000000);
    }

    /**
     * Get the number of columns in the grid.
     *
     * @param  int number of columns
     *
     * @return int
     */
    public function columns(): int
    {
        return $this->config[Options::COLUMNS];
    }

    /**
     * Get the size of each cell in the image that is created.
     *
     * @return int
     */
    public function imageCellSize(): int
    {
        return $this->config[Options::IMAGE_CELL_SIZE];
    }

    /**
     * Get the colors that are used when generating images from states.
     *
     * @return RgbColor[]|null
     */
    public function imageColors()
    {
        return $this->config[Options::IMAGE_COLORS];
    }

    /**
     * Get the hue (color) that is used when generating images from states.
     *
     * @return int
     */
    public function imageHue(): int
    {
         return $this->config[Options::IMAGE_HUE];
    }

    /**
     * Get the size (eg range) of the neighborhood.
     *
     * @return int
     */
    public function neighborhoodSize(): int
    {
        return $this->config[Options::NEIGHBORHOOD_SIZE];
    }

    /**
     * Get the neighborhood function, eg Moore or Neumann
     *
     * @return string type of neighborhood
     */
    public function neighborhoodType(): string
    {
        return $this->config[Options::NEIGHBORHOOD_TYPE];
    }

    /**
     * Get the number of rows in the grid.
     *
     * @return int
     */
    public function rows(): int
    {
        return $this->config[Options::ROWS];
    }

    /**
     * Get a seed for the random number generator. Use this for reproducable of runs.
     *
     * @return int
     */
    public function seed(): int
    {
        return $this->config[Options::SEED];
    }

    /**
     * Get the number of states that are cycled through.
     *
     * @return int
     */
    public function states(): int
    {
        return $this->config[Options::STATES];
    }

    /**
     * Get the threshold of the cells.
     *
     * @return int
     */
    public function threshold(): int
    {
        return $this->config[Options::THRESHOLD];
    }

    public function toArray(): array
    {
        return $this->config;
    }
}
