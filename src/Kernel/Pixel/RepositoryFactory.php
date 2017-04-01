<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Pixel;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorIndexInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Pixel repository object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Create ``PixelRepository``.
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
final class RepositoryFactory implements RepositoryFactoryInterface
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
     * @var ColorFactoryInterface
     */
    private $colorFactory;

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
     * @param ColorFactoryInterface $colorFactory
     * @param PixelFactoryInterface $pixelFactory
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ColorIndexInterface $colorIndex,
        ColorFactoryInterface $colorFactory,
        PixelFactoryInterface $pixelFactory,
        $className = 'Picamator\SteganographyKit2\Kernel\Pixel\Repository'
    ) {
        $this->objectManager = $objectManager;
        $this->colorIndex = $colorIndex;
        $this->colorFactory = $colorFactory;
        $this->pixelFactory = $pixelFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(ResourceInterface $resource) : RepositoryInterface
    {
        return $this->objectManager->create($this->className, [
            $resource,
            $this->colorIndex,
            $this->colorFactory,
            $this->pixelFactory
        ]);
    }
}
