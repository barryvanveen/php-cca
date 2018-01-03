<?php

namespace Barryvanveen\CCA\Generators;

use Barryvanveen\Exceptions\InvalidStateException;

class Gif
{

    /** @var array */
    protected $config;

    /** @var array */
    protected $grid;

    /** @var int */
    protected $generation;

    /** @var mixed */
    protected $image;

    /** @var int[] */
    protected $colors;

    protected function __construct(string $state)
    {
        try {
            $state = json_decode($state, true);

            $this->config = $state['config'];

            $this->grid = $state['grid'];

            $this->generation = $state['generation'];
        } catch (Exception $e) {
            throw new InvalidStateException();
        }

        $this->initImage();

        $this->initColors();

        $this->createImageOfCCA();
    }

    public static function createFromState(string $state)
    {
        return new self($state);
    }

    public function initImage()
    {
        $this->image = imagecreatetruecolor($this->getImageWidth(), $this->getImageHeight());
    }

    protected function getImageWidth(): int
    {
        return $this->config['rows'] * $this->config['cellsize'];
    }

    protected function getImageHeight(): int
    {
        return $this->config['columns'] * $this->config['cellsize'];
    }

    public function initColors()
    {
        $this->colors = [];

        $this->colors[0] = imagecolorallocate($this->image, 50, 149, 96);
        $this->colors[1] = imagecolorallocate($this->image, 82, 173, 124);
        $this->colors[2] = imagecolorallocate($this->image, 9, 101, 52);
        $this->colors[3] = imagecolorallocate($this->image, 50, 104, 134);
        $this->colors[4] = imagecolorallocate($this->image, 78, 128, 155);
        $this->colors[5] = imagecolorallocate($this->image, 12, 63, 91);
        $this->colors[6] = imagecolorallocate($this->image, 211, 147, 71);
        $this->colors[7] = imagecolorallocate($this->image, 245, 186, 115);
        $this->colors[8] = imagecolorallocate($this->image, 143, 84, 13);
        $this->colors[9] = imagecolorallocate($this->image, 211, 102, 71);
        $this->colors[10] = imagecolorallocate($this->image, 245, 145, 115);
        $this->colors[11] = imagecolorallocate($this->image, 143, 42, 13);
    }

    protected function createImageOfCCA()
    {
        $this->fillBackground();

        for ($row = 0; $row < $this->config['rows']; $row++) {
            for ($column = 0; $column < $this->config['columns']; $column++) {
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
        $position = ($row * $this->config['columns']) + $column;

        return $this->grid[$position];
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
        $x = $column * $this->config['cellsize'];
        $y = $row * $this->config['cellsize'];

        return [$x, $y];
    }

    protected function getCellBottomRight(int $row, int $column): array
    {
        list($x, $y) = $this->getCellTopLeft($row, $column);

        $x += ($this->config['cellsize'] - 1);
        $y += ($this->config['cellsize'] - 1);

        return [$x, $y];
    }

    protected function getColorFromState(int $state): int
    {
        return $this->colors[$state];
    }

    public function save(string $destination = 'image.gif')
    {
        return imagegif($this->image, $destination);
    }

    public function get()
    {
        return $this->image;
    }
}
