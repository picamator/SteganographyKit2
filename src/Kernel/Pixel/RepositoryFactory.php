<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Pixel;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorIndexInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;

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
     * @param ColorIndexInterface $colorIndex
     * @param ColorFactoryInterface $colorFactory
     * @param PixelFactoryInterface $pixelFactory
     */
    public function __construct(
        ColorIndexInterface $colorIndex,
        ColorFactoryInterface $colorFactory,
        PixelFactoryInterface $pixelFactory
    ) {
        $this->colorIndex = $colorIndex;
        $this->colorFactory = $colorFactory;
        $this->pixelFactory = $pixelFactory;
    }

    /**
     * @inheritDoc
     */
    public function create(ResourceInterface $resource) : RepositoryInterface
    {
        return new Repository(
            $resource,
            $this->colorIndex,
            $this->colorFactory,
            $this->pixelFactory
        );
    }
}
