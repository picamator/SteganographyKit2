<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Iterator;

use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ColorIndexInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\SerialIteratorInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\PointFactoryInterface;

/**
 * Serial iterator
 *
 * Iterate pixel-by-pixel, row-by-row form to the left top corner to the bottom right.
 *
 * Class type
 * ----------
 * Non-sharable
 *
 * Responsibility
 * --------------
 * Iterate over ``Resource``
 *
 * State
 * -----
 * * Iteration state: current, key, etc.
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Cannot be injected in any class. Iterator owns only by ``Resource``.
 *
 * @package Kernel\Image\Iterator
 */
class SerialIterator implements SerialIteratorInterface
{
    /**
     * @var ColorIndexInterface
     */
    private $colorIndex;

    /**
     * @var PointFactoryInterface
     */
    private $pointFactory;

    /**
     * @var PixelFactoryInterface
     */
    private $pixelFactory;

    /**
     * @var resource
     */
    private $resource;

    /**
     * Max value for X coordinate
     *
     * @var int
     */
    private $xMax;

    /**
     * Max value for Y coordinate
     *
     * @var int
     */
    private $yMax;

    /**
     * Current X coordinate
     *
     * @var int
     */
    private $x = 0;

    /**
     * Current Y coordinate
     *
     * @var int
     */
    private $y = 0;

    /**
     * Current index
     *
     * @var int
     */
    private $index = 0;

    /**
     * @param ResourceInterface $resource
     * @param ColorIndexInterface $colorIndex
     * @param PointFactoryInterface $pointFactory
     * @param PixelFactoryInterface $pixelFactory
     */
    public function __construct(
        ResourceInterface $resource,
        ColorIndexInterface $colorIndex,
        PointFactoryInterface $pointFactory,
        PixelFactoryInterface $pixelFactory
    ) {
        $this->colorIndex = $colorIndex;
        $this->pointFactory = $pointFactory;
        $this->pixelFactory = $pixelFactory;

        $this->resource = $resource->getResource();
        $this->xMax = $resource->getSize()->getWidth();
        $this->yMax = $resource->getSize()->getHeight();
    }

    /**
     * @inheritDoc
     *
     * @return PixelInterface
     */
    public function current()
    {
        $colorIndex = imagecolorat($this->resource, $this->x, $this->y);
        // strict types will rise exception for false color index
        $color = $this->colorIndex->getColor($colorIndex);
        $point = $this->pointFactory->create(['x' => $this->x, 'y' => $this->y]);

        return $this->pixelFactory->create($point, $color);
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->index ++;
        $this->x ++;
        if ($this->x >= $this->xMax) {
            $this->x = 0;
            $this->y ++;
        }
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        $xValid = $this->x < $this->xMax;
        $yValid = $this->y < $this->yMax;

        return  $xValid && $yValid;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->x = 0;
        $this->y = 0;
        $this->index = 0;
    }
}
