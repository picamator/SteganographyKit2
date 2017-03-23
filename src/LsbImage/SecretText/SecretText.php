<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\LsbImage\SecretText;

use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;

/**
 * SecretText is an information for hide or protection signature
 */
class SecretText implements SecretTextInterface
{
    /**
     * @var ImageInterface
     */
    private $image;

    /**
     * @param ImageInterface $image
     */
    public function __construct(ImageInterface $image)
    {
        $this->image = $image;
    }

    /**
     * @inheritDoc
     */
    public function getResource()
    {
        return $this->image->getResource();
    }

    /**
     * @inheritDoc
     */
    public function getCountBit(): int
    {
        $size = $this->image->getSize();

        return $size->getHeight() * $size->getWidth() *  3 * 8;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return $this->image->getIterator();
    }
}
