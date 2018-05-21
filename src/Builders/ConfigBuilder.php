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

    public static function createFromPreset(string $preset): self
    {
        $presetOptions = Presets::getPresetOptions($preset);

        $builder = new self();

        foreach ($presetOptions as $option => $value) {
            $builder->{$option}($value);
        }

        return $builder;
    }

    public function columns(int $columns)
    {
        $this->options[Options::COLUMNS] = $columns;

        $this->config = new Config($this->options);
    }

    public function imageCellSize(int $size)
    {
        $this->options[Options::IMAGE_CELL_SIZE] = $size;

        $this->config = new Config($this->options);
    }

    public function imageColors(array $colors)
    {
        $this->options[Options::IMAGE_COLORS] = $colors;

        $this->config = new Config($this->options);
    }

    public function imageHue(int $hue)
    {
        $this->options[Options::IMAGE_HUE] = $hue;

        $this->config = new Config($this->options);
    }

    public function neighborhoodSize(int $neighborhoodSize)
    {
        $this->options[Options::NEIGHBORHOOD_SIZE] = $neighborhoodSize;

        $this->config = new Config($this->options);
    }

    public function neighborhoodType(string $neighborhoodType)
    {
        $this->options[Options::NEIGHBORHOOD_TYPE] = $neighborhoodType;

        $this->config = new Config($this->options);
    }

    public function rows(int $rows)
    {
        $this->options[Options::ROWS] = $rows;

        $this->config = new Config($this->options);
    }

    public function seed(int $seed)
    {
        $this->options[Options::SEED] = $seed;

        $this->config = new Config($this->options);
    }

    public function states(int $states)
    {
        $this->options[Options::STATES] = $states;

        $this->config = new Config($this->options);
    }

    public function threshold(int $threshold)
    {
        $this->options[Options::THRESHOLD] = $threshold;

        $this->config = new Config($this->options);
    }

    public function get(): Config
    {
        return $this->config;
    }
}
