<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Iterator;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\PointFactory;

/**
 * Serial null iterator
 *
 * Iterate pixel-by-pixel, row-by-row form to the left top corner to the bottom right over non exist resource with height & width.
 *
 * Class type
 * ----------
 * Non-sharable
 *
 * Responsibility
 * --------------
 * Emulate iteration over ``Resource`` returning ``Pixel`` with null ``Color``
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
 * Can be injected only as constructor argument. It's not depend on any user's data.
 *
 * @package Kernel\Image\Iterator
 */
final class SerialNullIterator implements IteratorInterface
{
    /**
     * @var PixelFactoryInterface
     */
    private $pixelFactory;

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
     * @param SizeInterface $size
     * @param PixelFactoryInterface $pixelFactory
     */
    public function __construct(
        SizeInterface $size,
        PixelFactoryInterface $pixelFactory
    ) {
        $this->xMax = $size->getWidth();
        $this->yMax = $size->getHeight();
        $this->pixelFactory = $pixelFactory;
    }

    /**
     * @inheritDoc
     *
     * @return PixelInterface
     */
    public function current()
    {
        $point = $this->createPoint($this->x, $this->y);

        return $this->pixelFactory->create($point);
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

    /**
     * Create point
     *
     * @param int $x
     * @param int $y
     *
     * @return \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface
     */
    private function createPoint(int $x, int $y)
    {
        return PointFactory::create($x, $y);
    }
}
