<?php

namespace Barryvanveen\CCA\Generators;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Coordinate;
use Barryvanveen\CCA\State;
use Phim\Color;

abstract class Image
{
    /** @var Config */
    protected $config;

    /** @var array */
    protected $grid;

    /** @var mixed */
    protected $image;

    /** @var int[] */
    protected $colors;

    protected function __construct(Config $config, State $state)
    {
        $this->config = $config;

        $this->grid = $state->toArray();

        $this->initImage();

        $this->initColors();

        $this->createImage();
    }

    abstract public static function createFromState(Config $config, State $state);

    public function initImage()
    {
        $this->image = imagecreatetruecolor($this->getImageWidth(), $this->getImageHeight());
    }

    protected function getImageWidth(): int
    {
        return $this->config->columns() * $this->config->image_cell_size();
    }

    protected function getImageHeight(): int
    {
        return $this->config->rows() * $this->config->image_cell_size();
    }

    public function initColors()
    {
        $this->colors = [];

        $states = $this->config->states();

        $hue = $this->config->image_hue();

        $this->colors = $this->getEvenlyDistributedColors($hue, $states);
    }

    protected function getEvenlyDistributedColors(int $hue, int $numberOfColors): array
    {
        $saturationStepsize = 1/$numberOfColors;
        $saturationStart = $saturationStepsize/2;

        $colors = [];

        for ($i = 0; $i<$numberOfColors; $i++) {
            $saturation = ($saturationStart + ($i * $saturationStepsize));

            $hsv = new Color\HsvColor($hue, $saturation, 1);

            $rgb = $hsv->toRgb();

            $colors[] = imagecolorallocate($this->image, $rgb->getRed(), $rgb->getGreen(), $rgb->getBlue());
        }

        return $colors;
    }

    protected function createImage()
    {
        $this->fillBackground();

        for ($row = 0; $row < $this->config->rows(); $row++) {
            for ($column = 0; $column < $this->config->columns(); $column++) {
                $state = $this->getStateFromGrid($row, $column);

                if ($state === 0) {
                    continue;
                }

                $this->fillCell($row, $column, $state);
            }
        }
    }

    protected function fillBackground()
    {
        imagefilledrectangle(
            $this->image,
            0,
            0,
            $this->getImageWidth(),
            $this->getImageHeight(),
            $this->colors[0]
        );
    }

    protected function getStateFromGrid(int $row, int $column): int
    {
        $coordinate = new Coordinate($row, $column, $this->config->columns());

        return $this->grid[$coordinate->position()];
    }

    protected function fillCell(int $row, int $column, int $state)
    {
        list($x1, $y1) = $this->getCellTopLeft($row, $column);

        list($x2, $y2) = $this->getCellBottomRight($row, $column);

        $color = $this->getColorFromState($state);

        imagefilledrectangle($this->image, $x1, $y1, $x2, $y2, $color);
    }

    protected function getCellTopLeft(int $row, int $column): array
    {
        $x = $column * $this->config->image_cell_size();
        $y = $row * $this->config->image_cell_size();

        return [$x, $y];
    }

    protected function getCellBottomRight(int $row, int $column): array
    {
        list($x, $y) = $this->getCellTopLeft($row, $column);

        $x += ($this->config->image_cell_size() - 1);
        $y += ($this->config->image_cell_size() - 1);

        return [$x, $y];
    }

    protected function getColorFromState(int $state): int
    {
        return $this->colors[$state];
    }

    public function get()
    {
        return $this->image;
    }

    abstract public function save();
}