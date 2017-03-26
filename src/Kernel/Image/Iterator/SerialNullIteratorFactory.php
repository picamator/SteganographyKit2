<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Iterator;

use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\PointFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Serial null iterator object
 *
 * Iterator factory makes possible to substitute iterator.
 * The ``Image`` depends on ``IteratorFactory`` and create iterator on first running ``Image->getIterator()``.
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Create ``Iterator``.
 *
 * State
 * -----
 * * No state
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor argument.
 *
 * @package Kernel\Image\Iterator
 *
 * @codeCoverageIgnore
 */
class SerialNullIteratorFactory implements IteratorFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ColorInterface
     */
    private $color;

    /**
     * @var PointFactoryInterface
     */
    private $pointFactory;

    /**
     * @var PixelFactoryInterface
     */
    private $pixelFactory;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ColorInterface $color
     * @param PointFactoryInterface $pointFactory
     * @param PixelFactoryInterface $pixelFactory
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ColorInterface $color,
        PointFactoryInterface $pointFactory,
        PixelFactoryInterface $pixelFactory,
        string $className = 'Picamator\SteganographyKit2\Kernel\Image\Iterator\SerialNullIterator'
    ) {
        $this->objectManager = $objectManager;
        $this->color = $color;
        $this->pointFactory = $pointFactory;
        $this->pixelFactory = $pixelFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(ResourceInterface $resource) : \Iterator
    {
        return $this->objectManager->create($this->className, [
            $resource->getSize(),
            $this->color,
            $this->pointFactory,
            $this->pixelFactory,
        ]);
    }
}
