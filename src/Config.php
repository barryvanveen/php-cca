<?php

declare(strict_types=1);

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Config\NeighborhoodOptions;
use Barryvanveen\CCA\Config\Options;
use Barryvanveen\CCA\Config\Validator;
use Barryvanveen\CCA\Interfaces\ConfigInterface;
use Phim\Color\RgbColor;

class Config implements ConfigInterface
{
    protected $config = [
        Options::COLUMNS           => 48,
        Options::IMAGE_CELL_SIZE   => 2,
        Options::IMAGE_COLORS      => null,
        Options::IMAGE_HUE         => null,
        Options::NEIGHBORHOOD_TYPE => NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE,
        Options::NEIGHBORHOOD_SIZE => 1,
        Options::ROWS              => 48,
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
     * Set or get the number of columns in the grid.
     *
     * @param  int number of columns
     *
     * @return int
     */
    public function columns($columns = null): int
    {
        return $this->config[Options::COLUMNS];
    }

    /**
     * Set or get the size of each cell in the image that is created.
     *
     * @param int $cellsize
     *
     * @return int
     */
    public function imageCellSize($cellsize = null): int
    {
        return $this->config[Options::IMAGE_CELL_SIZE];
    }

    /**
     * Set or get the colors that are used when generating images from states. Setting specific colors
     * overrides the hue configuration.
     *
     * @param RgbColor[] $colors
     *
     * @return RgbColor[]|null
     */
    public function imageColors($colors = null)
    {
        return $this->config[Options::IMAGE_COLORS];
    }

    /**
     * Set or get the hue (color) that is used when generating images from states. Colors
     * that are set using the imageColors-method take precedence over the hue.
     *
     * @param int $hue
     *
     * @return int
     */
    public function imageHue($hue = null): int
    {
         return $this->config[Options::IMAGE_HUE];
    }

    /**
     * Set or get the size (eg range) of the neighborhood.
     *
     * @param int $neighborhoodSize size of neighborhood
     *
     * @return int
     */
    public function neighborhoodSize($neighborhoodSize = null): int
    {
        return $this->config[Options::NEIGHBORHOOD_SIZE];
    }

    /**
     * Set or get the neighborhood function, eg Moore or Neumann
     *
     * @see NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE
     * @see NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN
     *
     * @param string $neighborhoodType
     *
     * @return string type of neighborhood
     */
    public function neighborhoodType($neighborhoodType = null): string
    {
        return $this->config[Options::NEIGHBORHOOD_TYPE];
    }

    /**
     * Set or get the number of rows in the grid.
     *
     * @param  int number of rows
     *
     * @return int
     */
    public function rows($rows = null): int
    {
        return $this->config[Options::ROWS];
    }

    /**
     * Set or get a seed for the random number generator. Use this for reproducable of runs.
     *
     * @param int $seed
     *
     * @return int
     */
    public function seed($seed = null): int
    {
        return $this->config[Options::SEED];
    }

    /**
     * Set or get the number of states that are cycled through.
     *
     * @param  int number of states
     *
     * @return int
     */
    public function states($states = null): int
    {
        return $this->config[Options::STATES];
    }

    /**
     * Set or get the threshold of the cells.
     *
     * @param  int threshold
     *
     * @return int
     */
    public function threshold($threshold = null): int
    {
        return $this->config[Options::THRESHOLD];
    }

    public function toArray(): array
    {
        return $this->config;
    }
}
