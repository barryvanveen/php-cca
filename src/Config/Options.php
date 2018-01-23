<?php

namespace Barryvanveen\CCA\Config;

class Options
{
    const CELLSIZE          = 'cellsize'; // @todo: this should be an option on the image generator
    const COLUMNS           = 'columns';
    const NEIGHBORHOOD_SIZE = 'neighborhoodSize';
    const NEIGHBORHOOD_TYPE = 'neighborhoodType';
    const ROWS              = 'rows';
    const SEED              = 'seed';
    const STATES            = 'states';
    const THRESHOLD         = 'threshold';

    const VALID_OPTIONS = [
        self::CELLSIZE,
        self::COLUMNS,
        self::NEIGHBORHOOD_SIZE,
        self::NEIGHBORHOOD_TYPE,
        self::ROWS,
        self::SEED,
        self::STATES,
        self::THRESHOLD,
    ];
}
