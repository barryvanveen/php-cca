<?php

declare(strict_types=1);

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Config\NeighborhoodOptions;
use Barryvanveen\CCA\Config\Options;
use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Exceptions\InvalidColorException;
use Barryvanveen\CCA\Exceptions\InvalidHueException;
use Barryvanveen\CCA\Exceptions\InvalidNeighborhoodTypeException;
use Phim\Color\RgbColor;

class Config
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
     * Set or get the number of columns in the grid.
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
     * Set or get the size of each cell in the image that is created.
     *
     * @param int $cellsize
     *
     * @return int
     */
    public function imageCellSize($cellsize = null): int
    {
        if (isset($cellsize)) {
            $this->config[Options::IMAGE_CELL_SIZE] = (int) $cellsize;
        }

        return $this->config[Options::IMAGE_CELL_SIZE];
    }

    /**
     * Set or get the colors that are used when generating images from states. Setting specific colors
     * overrides the hue configuration.
     *
     * @param RgbColor[] $colors
     *
     * @return RgbColor[]|null
     *
     * @throws InvalidColorException
     */
    public function imageColors($colors = null)
    {
        if (isset($colors) && $this->colorsAreValid($colors)) {
            $this->config[Options::IMAGE_COLORS] = $colors;
        }

        return $this->config[Options::IMAGE_COLORS];
    }

    protected function colorsAreValid($colors): bool
    {
        if (!is_array($colors)) {
            throw new InvalidColorException("Colors must be passed as an array.");
        }

        foreach ($colors as $color) {
            if (!$color instanceof RgbColor) {
                throw new InvalidColorException();
            }
        }

        return true;
    }

    /**
     * Set or get the hue (color) that is used when generating images from states. Colors
     * that are set using the imageColors-method take precedence over the hue.
     *
     * @param int $hue
     *
     * @return int
     *
     * @throws InvalidHueException
     */
    public function imageHue($hue = null): int
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
     * Set or get the size (eg range) of the neighborhood.
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
     * Set or get the neighborhood function, eg Moore or Neumann
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
     * Set or get the number of rows in the grid.
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
     * Set or get a seed for the random number generator. Use this for reproducable of runs.
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
     * Set or get the number of states that are cycled through.
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
     * Set or get the threshold of the cells.
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
