<?php
namespace Picamator\SteganographyKit2\Entity\Api\Memento;

use Picamator\SteganographyKit2\Exception\InvalidArgumentException;

/**
 * Pixel care taker
 */
interface PixelCareTakerInterface
{
    /**
     * Adds memento
     *
     * @param PixelMementoInterface $memento
     *
     * @return PixelCareTakerInterface
     *
     * @throws InvalidArgumentException on attempt trying change bit twice
     */
    public function add(PixelMementoInterface $memento) : PixelCareTakerInterface;

    /**
     * Gets memento's list
     *
     * @return array
     */
    public function getList() : array;

    /**
     * Has color been changed
     *
     * @return bool true if color was changed, false otherwise
     */
    public function hasChanged() : bool;
}
