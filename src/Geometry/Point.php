<?php

namespace ArtisanWebLab\GeoJson\Geometry;

use InvalidArgumentException;

/**
 * Point geometry object.
 * Coordinates consist of a single position.
 *
 * @see   http://www.geojson.org/geojson-spec.html#point
 * @since 1.0
 */
class Point extends Geometry
{
    protected string $type = 'Point';

    /**
     * Point constructor.
     *
     * @param array $position
     */
    public function __construct(array $position)
    {
        if (count($position) < 2) {
            throw new InvalidArgumentException('Position requires at least two elements');
        }

        foreach ($position as $value) {
            if (!is_numeric($value)) {
                throw new InvalidArgumentException('Position elements must be integers or floats');
            }
        }

        $this->coordinates = $position;
    }
}
