<?php
namespace Picamator\SteganographyKit2\Kernel\Primitive\Api\Data;

/**
 * Point value object
 *
 * @package Kernel\Primitive
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
