<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Image object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Create ``Image``.
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
 * @package Kernel\Image
 *
 * @codeCoverageIgnore
 */
final class ImageFactory implements ImageFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ResourceFactoryInterface
     */
    private $resourceFactory;

    /**
     * @var RepositoryFactoryInterface
     */
    private $repositoryFactory;

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
     * @param ResourceFactoryInterface $resourceFactory
     * @param RepositoryFactoryInterface $repositoryFactory
     * @param IteratorFactoryInterface $iteratorFactory
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ResourceFactoryInterface $resourceFactory,
        RepositoryFactoryInterface $repositoryFactory,
        IteratorFactoryInterface $iteratorFactory,
        $className = 'Picamator\SteganographyKit2\Kernel\Image\Image'
    ) {
        $this->objectManager = $objectManager;
        $this->resourceFactory = $resourceFactory;
        $this->repositoryFactory = $repositoryFactory;
        $this->iteratorFactory = $iteratorFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(InfoInterface $info) : ImageInterface
    {
        $resource = $this->resourceFactory->create($info);
        $repository = $this->repositoryFactory->create($resource);

        return $this->objectManager->create($this->className, [$repository, $this->iteratorFactory]);
    }
}
