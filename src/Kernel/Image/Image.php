<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ExportInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;

/**
 * Image
 *
 * Class type
 * ----------
 * Non-sharable service.
 *
 * Responsibility
 * --------------
 * * Create image iterator
 * * Delegate export
 *
 * State
 * -----
 * * Export result as an internal cache
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
 * * Single responsibility ``-``
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
     * @var ResourceInterface
     */
    private $resource;

    /**
     * @var IteratorFactoryInterface
     */
    private $iteratorFactory;

    /**
     * @var ExportInterface
     */
    private $exportStrategy;

    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @var string
     */
    private $exportResult;

    /**
     * @param ResourceInterface $resource
     * @param IteratorFactoryInterface $iteratorFactory
     * @param ExportInterface $exportStrategy
     */
    public function __construct(
        ResourceInterface $resource,
        IteratorFactoryInterface $iteratorFactory,
        ExportInterface $exportStrategy
    ) {
        $this->resource = $resource;
        $this->iteratorFactory = $iteratorFactory;
        $this->exportStrategy = $exportStrategy;
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

    /**
     * @inheritDoc
     */
    public function export(): string
    {
        if (is_null($this->exportResult)) {
            $this->exportResult = $this->exportStrategy->export($this->resource);
        }

        return $this->exportResult;
    }
}
