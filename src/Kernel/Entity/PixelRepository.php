<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Entity;

use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelRepositoryInterface;
use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ColorIndexInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;

/**
 * Pixel Repository
 */
class PixelRepository implements PixelRepositoryInterface
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
     * @var ColorFactoryInterface
     */
    private $colorFactory;

    /**
     * @param ResourceInterface $resource
     * @param ColorIndexInterface $colorIndex
     * @param ColorFactoryInterface $colorFactory
     */
    public function __construct(
        ResourceInterface $resource,
        ColorIndexInterface $colorIndex,
        ColorFactoryInterface $colorFactory
    ) {
        $this->resource = $resource;
        $this->colorIndex = $colorIndex;
        $this->colorFactory = $colorFactory;
    }

    /**
     * @inheritDoc
     */
    public function update(PixelInterface $pixel, array $data)
    {
        $data = array_merge($pixel->getColor()->toArray(), $data);
        $color = $this->colorFactory->create($data);

        $pixel->setColor($color);
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
}
