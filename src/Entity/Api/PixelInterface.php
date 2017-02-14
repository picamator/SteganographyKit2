<?php
namespace Picamator\SteganographyKit2\Entity\Api;

use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface;

/**
 * Pixel entity
 */
interface PixelInterface extends \IteratorAggregate
{
    /**
     * Gets id
     *
     * Identifier consists of point combination 'x' + 'y'
     *
     * @return string
     */
    public function getId() : string;

    /**
     * Gets point
     *
     * @return PointInterface
     */
    public function getPoint() : PointInterface;

    /**
     * Gets color
     *
     * @return null | ColorInterface
     */
    public function getColor();

    /**
     * Sets color
     *
     * @param ColorInterface $color
     *
     * @return PixelInterface
     */
    public function setColor(ColorInterface $color);

    /**
     * Has pixel changed
     *
     * @return bool true if pixel was changed or false otherwise
     */
    public function hasChanged() : bool;
}
