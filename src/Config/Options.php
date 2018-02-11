<?php

namespace Barryvanveen\CCA\Config;

class Options
{
    const COLUMNS           = 'columns';
    const IMAGE_CELL_SIZE   = 'image_cell_size';
    const IMAGE_COLORS      = 'image_colors';
    const IMAGE_HUE         = 'image_hue';
    const NEIGHBORHOOD_SIZE = 'neighborhoodSize';
    const NEIGHBORHOOD_TYPE = 'neighborhoodType';
    const ROWS              = 'rows';
    const SEED              = 'seed';
    const STATES            = 'states';
    const THRESHOLD         = 'threshold';

    const VALID_OPTIONS = [
        self::COLUMNS,
        self::IMAGE_CELL_SIZE,
        self::IMAGE_COLORS,
        self::IMAGE_HUE,
        self::NEIGHBORHOOD_SIZE,
        self::NEIGHBORHOOD_TYPE,
        self::ROWS,
        self::SEED,
        self::STATES,
        self::THRESHOLD,
    ];
}
