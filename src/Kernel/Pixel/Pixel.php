<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Pixel;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;

/**
 * Pixel entity
 *
 * Class type
 * ----------
 * Non-sharable entity. Each ``Pixel`` represent physical image pixel.
 * The entity identifier is an composition of XY coordinates.
 *
 * Responsibility
 * --------------
 * Iterate over ``Color`` channels.
 *
 * State
 * -----
 * * Iteration state: current, key, etc.
 * * Pixel's value object components
 *
 * Immutability
 * ------------
 * Object is mutable.
 * Only the ``PixelRepository`` is responsible for changing ``Pixel``.
 *
 * Dependency injection
 * --------------------
 * Only as a method argument. The ``Pixel`` object generates by ``Image`` iterator using ``PixelFactory``.
 * Therefore ``Pixel`` is a result of iteration over ``Image``.
 *
 * Check list
 * ----------
 * * Single responsibility ``+``
 * * Tell don't ask ``+``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
 *
 * @package Kernel\Pixel
 */
final class Pixel implements PixelInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var PointInterface
     */
    private $point;

    /**
     * @var ColorInterface
     */
    private $color;

    /**
     * @var IteratorFactoryInterface
     */
    private $iteratorFactory;

    /**
     * @var bool
     */
    private $changed = false;

    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @param PointInterface $point
     * @param ColorInterface $color
     * @param IteratorFactoryInterface $iteratorFactory
     */
    public function __construct(
        PointInterface $point,
        ColorInterface $color,
        IteratorFactoryInterface $iteratorFactory
    ) {
        $this->point = $point;
        $this->color = $color;
        $this->iteratorFactory = $iteratorFactory;
    }

    /**
     * Cloning object with iterator might be tricky,
     * Especially when iterator instance are internally caching
     *
     * @codeCoverageIgnore
     */
    final private function __clone()
    {
    }

    /**
     * @inheritDoc
     */
    public function getId() : string
    {
        if (is_null($this->id)) {
            $this->id = $this->point->getX() . $this->point->getY();
        }

        return $this->id;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getPoint() : PointInterface
    {
        return $this->point;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @inheritDoc
     */
    public function setColor(ColorInterface $color) : PixelInterface
    {
        // color could be the same object if nothing to change
        if ($color !== $this->color
            && $color->toString() !== $this->color->toString()
        ) {
            $this->changed = true;
        }

        $this->color = $color;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function hasChanged(): bool
    {
        return $this->changed;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        if (is_null($this->iterator)) {
            $this->iterator = $this->iteratorFactory->create($this);
        }

        return $this->iterator;
    }
}
