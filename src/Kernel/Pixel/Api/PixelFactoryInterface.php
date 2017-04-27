<?php
namespace Picamator\SteganographyKit2\Kernel\Pixel\Api;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;

/**
 * Create Pixel entity
 *
 * @package Kernel\Pixel
 */
interface PixelFactoryInterface
{
    /**
     * Create
     *
     * @param PointInterface $point
     * @param ColorInterface | null $color
     *
     * @return PixelInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(PointInterface $point, ColorInterface $color = null) : PixelInterface;
}
