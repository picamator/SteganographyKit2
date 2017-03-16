<?php
namespace Picamator\SteganographyKit2\Kernel\Entity\Api;

use Picamator\SteganographyKit2\Kernel\Entity\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;

/**
 * Create Pixel entity
 */
interface PixelFactoryInterface
{
    /**
     * Create
     *
     * @param PointInterface $point
     * @param ColorInterface $color
     * @param IteratorFactoryInterface|null $iteratorFactory
     *
     * @return PixelInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(
        PointInterface $point,
        ColorInterface $color,
        IteratorFactoryInterface $iteratorFactory = null
    ) : PixelInterface;
}
