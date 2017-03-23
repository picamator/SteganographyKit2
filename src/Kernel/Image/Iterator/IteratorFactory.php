<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Iterator;

use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ColorIndexInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\PointFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Iterator object
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
class IteratorFactory implements IteratorFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

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
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ColorIndexInterface $colorIndex
     * @param PointFactoryInterface $pointFactory
     * @param PixelFactoryInterface $pixelFactory
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ColorIndexInterface $colorIndex,
        PointFactoryInterface $pointFactory,
        PixelFactoryInterface $pixelFactory,
        string $className = 'Picamator\SteganographyKit2\Kernel\Image\Iterator\SerialIterator'
    ) {
        $this->objectManager = $objectManager;
        $this->colorIndex = $colorIndex;
        $this->pointFactory = $pointFactory;
        $this->pixelFactory = $pixelFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(ImageInterface $image) : \Iterator
    {
        return $this->objectManager->create($this->className, [
            $image,
            $this->colorIndex,
            $this->pointFactory,
            $this->pixelFactory,
        ]);
    }
}
