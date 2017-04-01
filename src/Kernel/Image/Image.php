<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryInterface;

/**
 * Image
 *
 * Class type
 * ----------
 * Non-sharable service.
 *
 * Responsibility
 * --------------
 * Create image iterator
 *
 * State
 * -----
 * * Iteration over image
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a method argument, because ``Image`` depends on ``Resource``.
 *
 * Check list
 * ----------
 * * Single responsibility ``+``
 * * Tell don't ask ``+``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
 *
 * @package Kernel\Image
 */
class Image implements ImageInterface
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var IteratorFactoryInterface
     */
    private $iteratorFactory;

    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @param RepositoryInterface $repository
     * @param IteratorFactoryInterface $iteratorFactory
     */
    public function __construct(
        RepositoryInterface $repository,
        IteratorFactoryInterface $iteratorFactory
    ) {
        $this->repository = $repository;
        $this->iteratorFactory = $iteratorFactory;
    }

    /**
     * Cloning object with iterator might be tricky,
     * Especially when iterator instance are internally caching
     */
    private function __clone()
    {
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getRepository(): RepositoryInterface
    {
        return $this->repository;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getResource(): ResourceInterface
    {
        return $this->repository->getResource();
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getInfo(): InfoInterface
    {
        return $this->repository->getResource()->getInfo();
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        if (is_null($this->iterator)) {
            $this->iterator = $this->iteratorFactory->create($this);
        }

        return $this->iterator;
    }
}
