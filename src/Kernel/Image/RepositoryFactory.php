<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ColorIndexInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\RepositoryFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\RepositoryInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Repository object
 *
 * @codeCoverageIgnore
 */
class RepositoryFactory implements RepositoryFactoryInterface
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
        $className = 'Picamator\SteganographyKit2\Kernel\Image\Repository'
    ) {
        $this->objectManager = $objectManager;
        $this->colorIndex = $colorIndex;
        $this->colorFactory = $colorFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(ImageInterface $image) : RepositoryInterface
    {
        return $this->objectManager->create($this->className, [$image, $this->colorIndex, $this->colorFactory]);
    }
}
