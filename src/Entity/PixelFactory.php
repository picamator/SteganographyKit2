<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Entity;

use Picamator\SteganographyKit2\Entity\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Entity\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;

/**
 * Create Pixel object
 *
 * @codeCoverageIgnore
 */
class PixelFactory implements PixelFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var IteratorFactoryInterface
     */
    private $iteratorFactory;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param IteratorFactoryInterface $iteratorFactory
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        IteratorFactoryInterface $iteratorFactory,
        string $className = 'Picamator\SteganographyKit2\Entity\Pixel'
    ) {
        $this->objectManager = $objectManager;
        $this->iteratorFactory = $iteratorFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(
        PointInterface $point,
        ColorInterface $color,
        IteratorFactoryInterface $iteratorFactory = null
    ) : PixelInterface {

        $iteratorFactory = $iteratorFactory ?? $this->iteratorFactory;

        return $this->objectManager->create($this->className, [$point, $color, $iteratorFactory]);
    }
}
