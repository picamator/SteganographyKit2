<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Pixel;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryInterface;
use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorIndexInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Builder\ColorFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface;

/**
 * Pixel Repository
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Execute operation over resource:
 * * Update
 * * Insert
 * * Find
 *
 * State
 * -----
 * * Resource
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a method argument. The ``PixelRepository`` is built by ``PixelRepositoryFactory``.
 *
 * Check list
 * ----------
 * * Single responsibility ``+``
 * * Tell don't ask ``+``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
 *
 * @package Kernel\Pixel
 */
class Repository implements RepositoryInterface
{
    /**
     * @var ResourceInterface
     */
    private $resource;

    /**
     * @var ColorIndexInterface
     */
    private $colorIndex;

    /**
     * @var PixelFactoryInterface
     */
    private $pixelFactory;

    /**
     * For performance it's better to configure DI with Proxy injection
     *
     * @param ResourceInterface $resource
     * @param ColorIndexInterface $colorIndex
     * @param PixelFactoryInterface $pixelFactory
     */
    public function __construct(
        ResourceInterface $resource,
        ColorIndexInterface $colorIndex,
        PixelFactoryInterface $pixelFactory
    ) {
        $this->resource = $resource;
        $this->colorIndex = $colorIndex;
        $this->pixelFactory = $pixelFactory;
    }

    /**
     * @inheritDoc
     */
    public function update(PixelInterface $pixel, array $data)
    {
        $oldData = $pixel->getColor()->toArray();
        $data = array_merge($oldData, $data);

        // if data is identical no need to create new color object
        if($oldData === $data) {
            return;
        }

        $color = $this->createColor($data);
        $pixel->setColor($color);

        // in case when data elements not the same but could have the same properties
        if (!$pixel->hasChanged()) {
            return;
        }

        $this->insert($pixel);
    }

    /**
     * @inheritDoc
     */
    public function insert(PixelInterface $pixel)
    {
        $color = $this->colorIndex->getColorallocate($pixel->getColor());
        $point = $pixel->getPoint();

        $result = imagesetpixel($this->resource->getResource(), $point->getX(), $point->getY(), $color);
        // @codeCoverageIgnoreStart
        if ($result === false) {
            throw new RuntimeException(
                sprintf('Failed to modify pixel [%s, %s]', $point->getX(), $point->getY())
            );
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * @inheritDoc
     */
    public function find(PointInterface $point): PixelInterface
    {
        $colorIndex = imagecolorat($this->resource->getResource(), $point->getX(), $point->getY());
        // strict types will rise exception for false color index
        $color = $this->colorIndex->getColor($colorIndex);

        return $this->pixelFactory->create($point, $color);
    }

    /**
     * @inheritDoc
     */
    public function getResource(): ResourceInterface
    {
        return $this->resource;
    }

    /**
     * Create color
     *
     * @param array $data
     *
     * @return ColorInterface
     */
    private function createColor(array $data)
    {
        return ColorFactory::create($data);
    }
}
