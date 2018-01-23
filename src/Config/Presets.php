<?php

namespace Barryvanveen\CCA\Config;

use Barryvanveen\CCA\Exceptions\InvalidPresetException;

class Presets
{
    const PRESET_313 = '313';
    const PRESET_GH = 'gh';
    const PRESET_LAVALAMP = 'lavalamp';
    const PRESET_AMOEBA = 'amoeba';
    const PRESET_CCA = 'cca';
    const PRESET_CUBISM = 'cubism';
    const PRESET_CYCLIC_SPIRALS = 'cyclic_spirals';

    const VALID_PRESETS = [
        Presets::PRESET_313,
        Presets::PRESET_GH,
        Presets::PRESET_LAVALAMP,
        Presets::PRESET_AMOEBA,
        Presets::PRESET_CCA,
        Presets::PRESET_CUBISM,
        Presets::PRESET_CYCLIC_SPIRALS,
    ];

    protected static $preset_values = [
        self::PRESET_313 => [
            Options::NEIGHBORHOOD_SIZE => 1,
            Options::NEIGHBORHOOD_TYPE => NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE,
            Options::STATES => 3,
            Options::THRESHOLD => 3,
        ],
        self::PRESET_GH => [
            Options::NEIGHBORHOOD_SIZE => 3,
            Options::NEIGHBORHOOD_TYPE => NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE,
            Options::STATES => 8,
            Options::THRESHOLD => 5,
        ],
        self::PRESET_LAVALAMP => [
            Options::NEIGHBORHOOD_SIZE => 2,
            Options::NEIGHBORHOOD_TYPE => NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE,
            Options::STATES => 3,
            Options::THRESHOLD => 10,
        ],
        self::PRESET_AMOEBA => [
            Options::NEIGHBORHOOD_SIZE => 3,
            Options::NEIGHBORHOOD_TYPE => NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN,
            Options::STATES => 2,
            Options::THRESHOLD => 10,
        ],
        self::PRESET_CCA => [
            Options::NEIGHBORHOOD_SIZE => 1,
            Options::NEIGHBORHOOD_TYPE => NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN,
            Options::STATES => 14,
            Options::THRESHOLD => 1,
        ],
        self::PRESET_CUBISM => [
            Options::NEIGHBORHOOD_SIZE => 2,
            Options::NEIGHBORHOOD_TYPE => NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN,
            Options::STATES => 3,
            Options::THRESHOLD => 5,
        ],
        self::PRESET_CYCLIC_SPIRALS => [
            Options::NEIGHBORHOOD_SIZE => 3,
            Options::NEIGHBORHOOD_TYPE => NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE,
            Options::STATES => 8,
            Options::THRESHOLD => 5,
        ],
    ];

    public static function getPresetConfig(string $preset): array
    {
        if (!in_array($preset, Presets::VALID_PRESETS)) {
            throw new InvalidPresetException();
        }

        return self::$preset_values[$preset];
    }
}
