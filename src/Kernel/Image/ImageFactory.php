<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryFactoryInterface;

/**
 * Create Image object
 *
 * @package Kernel\Image
 *
 * @codeCoverageIgnore
 */
final class ImageFactory implements ImageFactoryInterface
{
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
     * @param ResourceFactoryInterface $resourceFactory
     * @param RepositoryFactoryInterface $repositoryFactory
     * @param IteratorFactoryInterface $iteratorFactory
     */
    public function __construct(
        ResourceFactoryInterface $resourceFactory,
        RepositoryFactoryInterface $repositoryFactory,
        IteratorFactoryInterface $iteratorFactory
    ) {
        $this->resourceFactory = $resourceFactory;
        $this->repositoryFactory = $repositoryFactory;
        $this->iteratorFactory = $iteratorFactory;
    }

    /**
     * @inheritDoc
     */
    public function create(InfoInterface $info) : ImageInterface
    {
        $resource = $this->resourceFactory->create($info);
        $repository = $this->repositoryFactory->create($resource);

        return new Image($repository, $this->iteratorFactory);
    }
}
