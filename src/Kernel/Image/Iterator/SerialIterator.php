<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Iterator;

use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\PointFactoryInterface;

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
final class SerialIterator implements IteratorInterface
{
    /**
     * @var ImageInterface
     */
    private $image;

    /**
     * @var PointFactoryInterface
     */
    private $pointFactory;

    /**
     * @var RepositoryInterface
     */
    private $repository;

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
     * @param ImageInterface $image
     * @param PointFactoryInterface $pointFactory
     */
    public function __construct(
        ImageInterface $image,
        PointFactoryInterface $pointFactory
    ) {
        $this->image =  $image;
        $this->pointFactory = $pointFactory;

        $this->repository = $image->getRepository();

        $size = $image->getInfo()->getSize();
        $this->xMax = $size->getWidth();
        $this->yMax = $size->getHeight();
    }

    /**
     * @inheritDoc
     *
     * @return \Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface
     */
    public function current()
    {
        $point = $this->pointFactory->create($this->x, $this->y);

        return $this->repository->find($point);
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
