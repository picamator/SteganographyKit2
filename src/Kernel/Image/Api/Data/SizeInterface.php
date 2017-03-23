<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api\Data;

/**
 * Size value object
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
