<?php

namespace Barryvanveen\CCA\Config;

class NeighborhoodOptions
{
    const NEIGHBORHOOD_TYPES = [
        self::NEIGHBORHOOD_TYPE_MOORE,
        self::NEIGHBORHOOD_TYPE_NEUMANN,
    ];

    const NEIGHBORHOOD_TYPE_NEUMANN = 'neumann';

    const NEIGHBORHOOD_TYPE_MOORE   = 'moore';
}
