<?php
namespace Picamator\SteganographyKit2\Kernel\Primitive\Api\Data;

/**
 * Size value object
 *
 * @package Kernel\Primitive
 */
interface SizeInterface
{
    /**
     * Gets width
     *
     * @return int
     */
    public function getWidth() : int;

    /**
     * Gets height
     *
     * @return int
     */
    public function getHeight() : int;
}
