<?php
namespace Picamator\SteganographyKit2\Primitive\Api\Data;

/**
 * Point value object
 */
interface PointInterface
{
    /**
     * Gets X
     *
     * @return int
     */
    public function getX() : int;

    /**
     * Gets Y
     *
     * @return int
     */
    public function getY() : int;
}
