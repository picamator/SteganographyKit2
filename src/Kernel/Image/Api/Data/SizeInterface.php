<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api\Data;

/**
 * Size value object
 *
 * @package Kernel\Image
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
