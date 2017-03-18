<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;

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
     * @var \Iterator
     */
    private $iterator;

    /**
     * @param ResourceInterface $resource
     * @param IteratorFactoryInterface $iteratorFactory
     */
    public function __construct(
        ResourceInterface $resource,
        IteratorFactoryInterface $iteratorFactory
    ) {
        $this->resource = $resource;
        $this->iteratorFactory = $iteratorFactory;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getResource() : ResourceInterface
    {
        return $this->resource;
    }

    /**
     * @inheritDoc
     */
    public function getSize(): SizeInterface
    {
        return $this->resource->getSize();
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
