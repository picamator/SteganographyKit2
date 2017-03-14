<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Image\Iterator;

use Picamator\SteganographyKit2\Entity\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Image\Api\ColorIndexInterface;
use Picamator\SteganographyKit2\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Image\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Primitive\Api\PointFactoryInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;

/**
 * Create Iterator object
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
        string $className = 'Picamator\SteganographyKit2\Image\Iterator\SerialIterator'
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
