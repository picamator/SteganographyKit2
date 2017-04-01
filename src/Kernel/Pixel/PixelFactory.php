<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Pixel;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface;
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
 * @package Kernel\Pixel
 *
 * @codeCoverageIgnore
 */
final class PixelFactory implements PixelFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ColorInterface
     */
    private $nullColor;

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
     * @param ColorInterface $nullColor
     * @param IteratorFactoryInterface $iteratorFactory
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ColorInterface $nullColor,
        IteratorFactoryInterface $iteratorFactory,
        string $className = 'Picamator\SteganographyKit2\Kernel\Pixel\Pixel'
    ) {
        $this->objectManager = $objectManager;
        $this->nullColor = $nullColor;
        $this->iteratorFactory = $iteratorFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(PointInterface $point, ColorInterface $color = null) : PixelInterface
    {
        if (is_null($color)) {
            $color = $this->nullColor;
        }

        return $this->objectManager->create($this->className, [$point, $color, $this->iteratorFactory]);
    }
}
