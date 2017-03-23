<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;

/**
 * Color index
 *
 * Helps to convert color index to color object and vice versa
 *
 * @package Kernel\Image
 */
interface ColorIndexInterface
{
    /**
     * Encode color index to rgb array with binary values
     *
     * @param int $colorIndex result of running imagecolorate
     *
     * @return ColorInterface
     */
    public function getColor(int $colorIndex) : ColorInterface;

    /**
     * Gets colorallocate
     *
     * @param ColorInterface $color
     *
     * @return int
     */
    public function getColorallocate(ColorInterface $color) : int;
}
