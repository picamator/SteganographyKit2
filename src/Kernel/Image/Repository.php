<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ColorIndexInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\RepositoryInterface;

/**
 * Image Repository
 */
class Repository implements RepositoryInterface
{
    /**
     * @var ImageInterface
     */
    private $image;

    /**
     * @var ColorIndexInterface
     */
    private $colorIndex;

    /**
     * @var ColorFactoryInterface
     */
    private $colorFactory;

    /**
     * @param ImageInterface $image
     * @param ColorIndexInterface $colorIndex
     * @param ColorFactoryInterface $colorFactory
     */
    public function __construct(
        ImageInterface $image,
        ColorIndexInterface $colorIndex,
        ColorFactoryInterface $colorFactory
    ) {
        $this->image = $image;
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

        $color = $this->colorIndex->getColorallocate($pixel->getColor());
        $point = $pixel->getPoint();

        $result = imagesetpixel($this->image->getResource()->getResource(), $point->getX(), $point->getY(), $color);
        // @codeCoverageIgnoreStart
        if ($result === false) {
            throw new RuntimeException(
                sprintf('Failed to modify pixel [%s, %s]', $point->getX(), $point->getY())
            );
        }
        // @codeCoverageIgnoreEnd
    }
}
