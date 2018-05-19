<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Generators;

use Barryvanveen\CCA\Exceptions\InvalidColorsException;
use Barryvanveen\CCA\Interfaces\ConfigInterface;
use Phim\Color;
use Phim\Color\HsvColor;

class Colors
{
    const HSV_VALUE = 1.0;

    /**
     * @param ConfigInterface $config
     *
     * @return Color\RgbColor[]
     *
     * @throws \Barryvanveen\CCA\Exceptions\InvalidColorException
     * @throws \Barryvanveen\CCA\Exceptions\InvalidColorsException
     * @throws \Barryvanveen\CCA\Exceptions\InvalidHueException
     */
    public static function getColors(ConfigInterface $config): array
    {
        if ($config->imageColors() === null) {
            return self::getEvenlyDistributedColors($config->imageHue(), $config->states());
        }

        $colors = $config->imageColors();

        if (count($colors) !== $config->states()) {
            throw new InvalidColorsException("Not enough colors specified.");
        }

        return $colors;
    }

    protected static function getEvenlyDistributedColors(int $hue, int $numberOfColors): array
    {
        $saturationStepSize = 1/$numberOfColors;
        $saturationStart = $saturationStepSize/2;

        $colors = [];

        for ($i = 0; $i<$numberOfColors; $i++) {
            $saturation = ($saturationStart + ($i * $saturationStepSize));

            $hsv = new HsvColor($hue, $saturation, self::HSV_VALUE);

            $colors[] = $hsv->toRgb();
        }

        return $colors;
    }
}
