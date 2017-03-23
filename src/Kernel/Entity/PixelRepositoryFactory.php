<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Entity;

use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelRepositoryFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelRepositoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ColorIndexInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Pixel repository object
 *
 * @codeCoverageIgnore
 */
class PixelRepositoryFactory implements PixelRepositoryFactoryInterface
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
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ColorIndexInterface $colorIndex
     * @param ColorFactoryInterface $colorFactory
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ColorIndexInterface $colorIndex,
        ColorFactoryInterface $colorFactory,
        $className = 'Picamator\SteganographyKit2\Kernel\Entity\PixelRepository'
    ) {
        $this->objectManager = $objectManager;
        $this->colorIndex = $colorIndex;
        $this->colorFactory = $colorFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(ResourceInterface $resource) : PixelRepositoryInterface
    {
        return $this->objectManager->create($this->className, [$resource, $this->colorIndex, $this->colorFactory]);
    }
}
