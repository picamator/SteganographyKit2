<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Entity;

use Picamator\SteganographyKit2\Kernel\Entity\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Pixel object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Create ``Pixel``.
 *
 * State
 * -----
 * No state
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor argument.
 *
 * @package Kernel\Entity
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
        string $className = 'Picamator\SteganographyKit2\Kernel\Entity\Pixel'
    ) {
        $this->objectManager = $objectManager;
        $this->iteratorFactory = $iteratorFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(PointInterface $point, ColorInterface $color) : PixelInterface
    {
        return $this->objectManager->create($this->className, [$point, $color, $this->iteratorFactory]);
    }
}
