<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Image;

use Picamator\SteganographyKit2\Image\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Image\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Image\Api\ResourceInterface;
use Picamator\SteganographyKit2\Image\Api\SizeFactoryInterface;

/**
 * Image
 */
class Image implements ImageInterface
{
    /**
     * @var ResourceInterface
     */
    private $resource;

    /**
     * @var IteratorFactoryInterface
     */
    private $iteratorFactory;

    /**
     * @var SizeFactoryInterface
     */
    private $sizeFactory;

    /**
     * @var SizeInterface
     */
    private $size;

    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @param ResourceInterface $resource
     * @param IteratorFactoryInterface $iteratorFactory
     * @param SizeFactoryInterface $sizeFactory
     */
    public function __construct(
        ResourceInterface $resource,
        IteratorFactoryInterface $iteratorFactory,
        SizeFactoryInterface $sizeFactory
    ) {
        $this->resource = $resource;
        $this->iteratorFactory = $iteratorFactory;
        $this->sizeFactory = $sizeFactory;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->resource->getPath();
    }

    /**
     * @inheritDoc
     */
    public function getResource()
    {
        return $this->resource->getResource();
    }

    /**
     * @inheritDoc
     */
    public function getSize(): SizeInterface
    {
        if (is_null($this->size)) {
            $this->size = $this->sizeFactory->create($this->getPath());
        }

        return $this->size;
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
