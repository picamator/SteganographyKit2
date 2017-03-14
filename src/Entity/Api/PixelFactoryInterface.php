<?php
namespace Picamator\SteganographyKit2\Entity\Api;

use Picamator\SteganographyKit2\Entity\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface;

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
     */
    public function create(
        PointInterface $point,
        ColorInterface $color,
        IteratorFactoryInterface $iteratorFactory = null
    ) : PixelInterface;
}
