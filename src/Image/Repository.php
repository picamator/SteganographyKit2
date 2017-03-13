<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Image;

use Picamator\SteganographyKit2\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Exception\RuntimeException;
use Picamator\SteganographyKit2\Image\Api\ColorIndexInterface;
use Picamator\SteganographyKit2\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Image\Api\RepositoryInterface;

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
     * @param ImageInterface $image
     * @param ColorIndexInterface $colorIndex
     */
    public function __construct(ImageInterface $image, ColorIndexInterface $colorIndex)
    {
        $this->image = $image;
        $this->colorIndex = $colorIndex;
    }

    /**
     * @inheritDoc
     */
    public function update(PixelInterface $pixel)
    {
        $color = $this->colorIndex->getColorallocate($pixel->getColor());
        $point = $pixel->getPoint();

        $result = imagesetpixel($this->image->getResource(), $point->getX(), $point->getY(), $color);
        if ($result === false) {
            throw new RuntimeException(
                sprintf('Failed to modify pixel [%s, %s]', $point->getX(), $point->getY())
            );
        }
    }
}
