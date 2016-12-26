<?php
namespace Picamator\SteganographyKit2\Entity\Api\Memento;

use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;

/**
 * Pixel memento
 */
interface PixelMementoInterface
{
    /**
     * Gets color
     *
     * @return ColorInterface
     */
    public function getColor() : ColorInterface;
}
