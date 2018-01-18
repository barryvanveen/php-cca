<?php

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Exceptions\InvalidNeighborhoodTypeException;

class Config
{
    const CCA_SEED = 'seed';
    const CCA_ROWS = 'rows';
    const CCA_COLUMNS = 'columns';
    const CCA_STATES = 'states';
    const CCA_THRESHOLD = 'threshold';
    const CCA_NEIGHBORHOOD_TYPE = 'neighborhood_type';
    const CCA_NEIGHBORHOOD_SIZE = 'neighborhood_size';

    // todo: extra neighborhood constants to separate file
    const NEIGHBORHOOD_TYPES = [
        self::NEIGHBORHOOD_TYPE_MOORE,
        self::NEIGHBORHOOD_TYPE_NEUMANN,
    ];

    const NEIGHBORHOOD_TYPE_MOORE = 'moore';
    const NEIGHBORHOOD_TYPE_NEUMANN = 'neumann';
    
    const GIF_CELLSIZE = 'cellsize';

    /** @var array */
    protected $config = [
        self::CCA_SEED => null,
        self::CCA_ROWS => 48,
        self::CCA_COLUMNS => 48,
        self::CCA_STATES => 3,
        self::CCA_THRESHOLD => 3,
        self::CCA_NEIGHBORHOOD_TYPE => self::NEIGHBORHOOD_TYPE_MOORE,
        self::CCA_NEIGHBORHOOD_SIZE => 1,

        self::GIF_CELLSIZE => 2,
    ];

    public function __construct()
    {
        $this->config[self::CCA_SEED] = $this->makeSeed();
    }

    /**
     * The amount of rows in the grid.
     *
     * @param  int number of rows
     *
     * @return int
     */
    public function rows($rows = null): int
    {
        if (isset($rows)) {
            $this->config[self::CCA_ROWS] = (int) $rows;
        }

        return $this->config[self::CCA_ROWS];
    }

    /**
     * The amount of columns in the grid.
     *
     * @param  int number of columns
     *
     * @return int
     */
    public function columns($columns = null): int
    {
        if (isset($columns)) {
            $this->config[self::CCA_COLUMNS] = (int) $columns;
        }

        return $this->config[self::CCA_COLUMNS];
    }

    /**
     * The number of states that each cell cycles through.
     *
     * @param  int number of states
     *
     * @return int
     */
    public function states($states = null): int
    {
        if (isset($states)) {
            $this->config[self::CCA_STATES] = (int) $states;
        }

        return $this->config[self::CCA_STATES];
    }

    /**
     * The threshold of the cells. Only when <threshold> or more of a cells' neighbors have
     * the successor state will the cell cycle to the successor state itself.
     *
     * @param  int threshold
     *
     * @return int
     */
    public function threshold($threshold = null): int
    {
        if (isset($threshold)) {
            $this->config[self::CCA_THRESHOLD] = (int) $threshold;
        }

        return $this->config[self::CCA_THRESHOLD];
    }

    /**
     * Set the neighborhood function, eg Moore or Neumann
     *
     * @see Config::NEIGHBORHOOD_TYPE_MOORE
     * @see Config::NEIGHBORHOOD_TYPE_NEUMANN
     *
     * @param string $neighborhoodType
     *
     * @return string type of neighborhood
     *
     * @throws \Barryvanveen\CCA\Exceptions\InvalidNeighborhoodTypeException
     */
    public function neighborhoodType($neighborhoodType = null): string
    {
        if (isset($neighborhoodType)) {
            if (!in_array($neighborhoodType, self::NEIGHBORHOOD_TYPES)) {
                throw new InvalidNeighborhoodTypeException();
            }

            $this->config[self::CCA_NEIGHBORHOOD_TYPE] = (string) $neighborhoodType;
        }

        return $this->config[self::CCA_NEIGHBORHOOD_TYPE];
    }

    /**
     * Set the size (eg range) of the neighborhood.
     *
     * @param int $neighborhoodSize size of neighborhood
     *
     * @return string
     */
    public function neighborhoodSize($neighborhoodSize = null): string
    {
        if (isset($neighborhoodSize)) {
            $this->config[self::CCA_NEIGHBORHOOD_SIZE] = (int) $neighborhoodSize;
        }

        return $this->config[self::CCA_NEIGHBORHOOD_SIZE];
    }

    /**
     * Set a seed for the random number generator. Use this for reproducable of runs.
     *
     * @param int $seed
     *
     * @return int
     */
    public function seed($seed = null): int
    {
        if (isset($seed)) {
            $this->config[self::CCA_SEED] = (int) $seed;
        }

        return $this->config[self::CCA_SEED];
    }

    public function toArray(): array
    {
        return $this->config;
    }

    private function makeSeed(): int
    {
        list($usec, $sec) = explode(' ', microtime());

        return $sec + $usec * 1000000;
    }
}
