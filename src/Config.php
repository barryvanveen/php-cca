<?php

declare(strict_types=1);

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Config\NeighborhoodOptions;
use Barryvanveen\CCA\Config\Options;
use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Exceptions\InvalidHueException;
use Barryvanveen\CCA\Exceptions\InvalidNeighborhoodTypeException;

class Config
{
    protected $config = [
        Options::COLUMNS           => 48,
        Options::IMAGE_CELL_SIZE   => 2,
        Options::IMAGE_HUE         => null,
        Options::NEIGHBORHOOD_TYPE => NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE,
        Options::NEIGHBORHOOD_SIZE => 1,
        Options::ROWS              => 48,
        Options::SEED              => null,
        Options::STATES            => 3,
        Options::THRESHOLD         => 3,
    ];

    public function __construct()
    {
        $this->config[Options::IMAGE_HUE] = $this->makeHue();

        $this->config[Options::SEED] = $this->makeSeed();
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

    public static function createFromPreset(string $preset): self
    {
        $presetConfig = Presets::getPresetConfig($preset);

        $config = new self();

        foreach ($presetConfig as $option => $value) {
            $config->{$option}($value);
        }

        return $config;
    }

    /**
     * The amount of columns in the grid.
     *
     * @param  int number of columns
     *
     * @return int
     */
    public function columns($columns = null): int
    {
        if (isset($columns)) {
            $this->config[Options::COLUMNS] = (int) $columns;
        }

        return $this->config[Options::COLUMNS];
    }

    /**
     * Set the size of each cell in the image that is created.
     *
     * @param int $cellsize
     *
     * @return int
     */
    public function image_cell_size($cellsize = null): int
    {
        if (isset($cellsize)) {
            $this->config[Options::IMAGE_CELL_SIZE] = (int) $cellsize;
        }

        return $this->config[Options::IMAGE_CELL_SIZE];
    }

    public function image_hue($hue = null): int
    {
        if (isset($hue) && $this->isValidHue($hue)) {
            $this->config[Options::IMAGE_HUE] = (int) $hue;
        }

        return $this->config[Options::IMAGE_HUE];
    }

    protected function isValidHue($hue): bool
    {
        if (!is_int($hue)) {
            throw new InvalidHueException("Hue is not an integer.");
        }

        if ($hue < 0 || $hue > 360) {
            throw new InvalidHueException("Hue should be an integer between 0 and 360.");
        }

        return true;
    }

    /**
     * Set the size (eg range) of the neighborhood.
     *
     * @param int $neighborhoodSize size of neighborhood
     *
     * @return int
     */
    public function neighborhoodSize($neighborhoodSize = null): int
    {
        if (isset($neighborhoodSize)) {
            $this->config[Options::NEIGHBORHOOD_SIZE] = (int) $neighborhoodSize;
        }

        return $this->config[Options::NEIGHBORHOOD_SIZE];
    }

    /**
     * Set the neighborhood function, eg Moore or Neumann
     *
     * @see NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE
     * @see NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN
     *
     * @param string $neighborhoodType
     *
     * @return string type of neighborhood
     *
     * @throws \Barryvanveen\CCA\Exceptions\InvalidNeighborhoodTypeException
     */
    public function neighborhoodType($neighborhoodType = null): string
    {
        if (isset($neighborhoodType)) {
            if (!in_array($neighborhoodType, NeighborhoodOptions::NEIGHBORHOOD_TYPES)) {
                throw new InvalidNeighborhoodTypeException();
            }

            $this->config[Options::NEIGHBORHOOD_TYPE] = (string) $neighborhoodType;
        }

        return $this->config[Options::NEIGHBORHOOD_TYPE];
    }

    /**
     * The amount of rows in the grid.
     *
     * @param  int number of rows
     *
     * @return int
     */
    public function rows($rows = null): int
    {
        if (isset($rows)) {
            $this->config[Options::ROWS] = (int) $rows;
        }

        return $this->config[Options::ROWS];
    }

    /**
     * Set a seed for the random number generator. Use this for reproducable of runs.
     *
     * @param int $seed
     *
     * @return int
     */
    public function seed($seed = null): int
    {
        if (isset($seed)) {
            $this->config[Options::SEED] = (int) $seed;
        }

        return $this->config[Options::SEED];
    }

    /**
     * The number of states that each cell cycles through.
     *
     * @param  int number of states
     *
     * @return int
     */
    public function states($states = null): int
    {
        if (isset($states)) {
            $this->config[Options::STATES] = (int) $states;
        }

        return $this->config[Options::STATES];
    }

    /**
     * The threshold of the cells. Only when <threshold> or more of a cells' neighbors have
     * the successor state will the cell cycle to the successor state itself.
     *
     * @param  int threshold
     *
     * @return int
     */
    public function threshold($threshold = null): int
    {
        if (isset($threshold)) {
            $this->config[Options::THRESHOLD] = (int) $threshold;
        }

        return $this->config[Options::THRESHOLD];
    }

    public function toArray(): array
    {
        return $this->config;
    }
}
