<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Config;

use Barryvanveen\CCA\Exceptions\InvalidOptionException;
use Barryvanveen\CCA\Exceptions\InvalidValueException;
use Phim\Color\RgbColor;

class Validator
{
    public static function validate(array $config): bool
    {
        foreach ($config as $option => $value) {
            if (!in_array($option, Options::VALID_OPTIONS)) {
                throw new InvalidOptionException("Invalid option ".$option.".");
            }

            $methodName = 'validate'.ucwords($option, '_');
            {
            }
            if (!self::$methodName($value)) {
                throw new InvalidValueException("Invalid value for option ".$option.".");
            }
        }

        return true;
    }

    /**
     * Validate whether the columns option is a positive integer.
     *
     * @param $value
     *
     * @return bool
     */
    protected static function validateColumns($value): bool
    {
        return self::validateNonNegativeInteger($value);
    }

    protected static function validateNonNegativeInteger($value): bool
    {
        if (!is_int($value)) {
            return false;
        }

        if ($value <= 0) {
            return false;
        }

        return true;
    }

    /**
     * Validate whether the imageCellSize option is a positive integer.
     *
     * @param $value
     *
     * @return bool
     */
    protected static function validateImageCellSize($value): bool
    {
        return self::validateNonNegativeInteger($value);
    }

    /**
     * Validate whether the imageColors option is an array of RgbColor instances.
     *
     * @param $value
     *
     * @return bool
     */
    protected static function validateImageColors($value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        foreach ($value as $color) {
            if (!$color instanceof RgbColor) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate whether imageHue is an integer between 0 and 360.
     *
     * @param $value
     *
     * @return bool
     */
    protected static function validateImageHue($value): bool
    {
        if (!is_int($value)) {
            return false;
        }

        if ($value < 0 || $value > 360) {
            return false;
        }

        return true;
    }

    /**
     * Validate whether the neighborhoodSize option is a positive integer.
     *
     * @param $value
     *
     * @return bool
     */
    protected static function validateNeighborhoodSize($value): bool
    {
        return self::validateNonNegativeInteger($value);
    }

    /**
     * Validate whether the neighborhoodType option is a valid option.
     *
     * @param $value
     *
     * @return bool
     */
    protected static function validateNeighborhoodType($value): bool
    {
        if (!in_array($value, NeighborhoodOptions::NEIGHBORHOOD_TYPES)) {
            return false;
        }

        return true;
    }

    /**
     * Validate whether the rows option is a positive integer.
     *
     * @param $value
     *
     * @return bool
     */
    protected static function validateRows($value): bool
    {
        return self::validateNonNegativeInteger($value);
    }

    /**
     * Validate whether the seed option is an integer.
     *
     * @param $value
     *
     * @return bool
     */
    protected static function validateSeed($value): bool
    {
        return is_int($value);
    }

    /**
     * Validate whether the states option is a positive integer.
     *
     * @param $value
     *
     * @return bool
     */
    protected static function validateStates($value): bool
    {
        return self::validateNonNegativeInteger($value);
    }

    /**
     * Validate whether the threshold option is a positive integer.
     *
     * @param $value
     *
     * @return bool
     */
    protected static function validateThreshold($value): bool
    {
        return self::validateNonNegativeInteger($value);
    }
}
