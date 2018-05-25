<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Generators;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Coordinate;
use Barryvanveen\CCA\State;

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

    protected function initImage()
    {
        $this->image = imagecreatetruecolor($this->getImageWidth(), $this->getImageHeight());
    }

    protected function getImageWidth(): int
    {
        return $this->config->columns() * $this->config->imageCellSize();
    }

    protected function getImageHeight(): int
    {
        return $this->config->rows() * $this->config->imageCellSize();
    }

    protected function initColors()
    {
        $colors = Colors::getColors($this->config);

        foreach ($colors as $color) {
            $this->colors[] = imagecolorallocate(
                $this->image,
                (int) $color->getRed(),
                (int) $color->getGreen(),
                (int) $color->getBlue()
            );
        }
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
        $x = $column * $this->config->imageCellSize();
        $y = $row * $this->config->imageCellSize();

        return [$x, $y];
    }

    protected function getCellBottomRight(int $row, int $column): array
    {
        list($x, $y) = $this->getCellTopLeft($row, $column);

        $x += ($this->config->imageCellSize() - 1);
        $y += ($this->config->imageCellSize() - 1);

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
