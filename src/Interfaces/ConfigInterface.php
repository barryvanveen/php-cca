<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Interfaces;

interface ConfigInterface
{
    public function columns($columns = null): int;
    public function imageCellSize($cellsize = null): int;
    public function imageColors($colors = null);
    public function imageHue($hue = null): int;
    public function neighborhoodSize($neighborhoodSize = null): int;
    public function neighborhoodType($neighborhoodType = null): string;
    public function rows($rows = null): int;
    public function seed($seed = null): int;
    public function states($states = null): int;
    public function threshold($threshold = null): int;
    public function toArray(): array;
}
