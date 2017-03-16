<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Entity;

use Picamator\SteganographyKit2\Kernel\Entity\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;

/**
 * Pixel entity
 */
class Pixel implements PixelInterface
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
    public function setColor(ColorInterface $color)
    {
        if ($color->toString() !== $this->color->toString()) {
            $this->changed = true;
        }

        $this->color = $color;
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
