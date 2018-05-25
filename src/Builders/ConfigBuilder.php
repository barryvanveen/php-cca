<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Builders;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Config\Options;
use Barryvanveen\CCA\Config\Presets;

class ConfigBuilder
{
    /** @var array */
    protected $options = [];

    /** @var Config */
    protected $config;

    public function __construct()
    {
        $this->options = [];

        $this->config = new Config($this->options);
    }

    /**
     * Instantiate the config based on a preset.
     *
     * @see \Barryvanveen\CCA\Config\Presets::VALID_PRESETS
     *
     * @param string $preset
     *
     * @return ConfigBuilder
     *
     * @throws \Barryvanveen\CCA\Exceptions\InvalidPresetException
     */
    public static function createFromPreset(string $preset): self
    {
        $presetOptions = Presets::getPresetOptions($preset);

        $builder = new self();

        foreach ($presetOptions as $option => $value) {
            $builder->{$option}($value);
        }

        return $builder;
    }

    /**
     * Set the number of columns.
     *
     * @param int $columns
     */
    public function columns(int $columns)
    {
        $this->options[Options::COLUMNS] = $columns;

        $this->config = new Config($this->options);
    }

    /**
     * Set the size of each cell in the generated image.
     *
     * @param int $size
     */
    public function imageCellSize(int $size)
    {
        $this->options[Options::IMAGE_CELL_SIZE] = $size;

        $this->config = new Config($this->options);
    }

    /**
     * Set the colors that should be used when generating images. Each color in the array should be an instance of
     * RgbColor. The number of colors should be equal to (or greater than) the number of states. Setting imageColors()
     * takes precedence over setting imageHue().
     *
     * @see \Phim\Color\RgbColor
     *
     * @param array $colors
     */
    public function imageColors(array $colors)
    {
        $this->options[Options::IMAGE_COLORS] = $colors;

        $this->config = new Config($this->options);
    }

    /**
     * Set the hue (e.g. the color) used to pick colors for the generated image. Colors are then picked by varying
     * the saturation of the color. Should be an integer between 0 and 360. Setting imageColors() takes
     * precedence over setting imageHue().
     *
     * @see https://en.wikipedia.org/wiki/HSL_and_HSV
     *
     * @param int $hue
     */
    public function imageHue(int $hue)
    {
        $this->options[Options::IMAGE_HUE] = $hue;

        $this->config = new Config($this->options);
    }

    /**
     * Set the size of the neighborhood.
     *
     * @param int $neighborhoodSize
     */
    public function neighborhoodSize(int $neighborhoodSize)
    {
        $this->options[Options::NEIGHBORHOOD_SIZE] = $neighborhoodSize;

        $this->config = new Config($this->options);
    }

    /**
     * Set the neighborhood type.
     *
     * @see \Barryvanveen\CCA\Config\NeighborhoodOptions::NEIGHBORHOOD_TYPES
     *
     * @param string $neighborhoodType
     */
    public function neighborhoodType(string $neighborhoodType)
    {
        $this->options[Options::NEIGHBORHOOD_TYPE] = $neighborhoodType;

        $this->config = new Config($this->options);
    }

    /**
     * Set the number of rows.
     *
     * @param int $rows
     */
    public function rows(int $rows)
    {
        $this->options[Options::ROWS] = $rows;

        $this->config = new Config($this->options);
    }

    /**
     * Set the seed with which to initiate the random number generator. Can be used for reproducible results or for
     * testing purposes.
     *
     * @param int $seed
     */
    public function seed(int $seed)
    {
        $this->options[Options::SEED] = $seed;

        $this->config = new Config($this->options);
    }

    /**
     * Set the number of states each cell can take on.
     *
     * @param int $states
     */
    public function states(int $states)
    {
        $this->options[Options::STATES] = $states;

        $this->config = new Config($this->options);
    }

    /**
     * Set the threshold. A cell must have at least this number of successor states among its neighbors in order for
     * itself to cycle to the successor state.
     *
     * @param int $threshold
     */
    public function threshold(int $threshold)
    {
        $this->options[Options::THRESHOLD] = $threshold;

        $this->config = new Config($this->options);
    }

    /**
     * Get the config object.
     *
     * @return Config
     */
    public function get(): Config
    {
        return $this->config;
    }
}
