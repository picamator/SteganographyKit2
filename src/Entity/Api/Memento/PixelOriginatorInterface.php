<?php
namespace Picamator\SteganographyKit2\Entity\Api\Memento;

use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;

/**
 * Pixel originator
 */
interface PixelOriginatorInterface
{
    /**
     * Sets color
     *
     * @param ColorInterface $color
     *
     * @return PixelOriginatorInterface
     */
    public function setColor(ColorInterface $color) : PixelOriginatorInterface;

    /**
     * Gets color
     *
     * @return ColorInterface
     */
    public function getColor() : ColorInterface;

    /**
     * Saves to memento
     *
     * @return PixelMementoInterface
     */
    public function saveToMemento() : PixelMementoInterface;

    /**
     * Gets from memento
     *
     * @return ColorInterface
     */
    public function getFromMemento() : ColorInterface;
}
