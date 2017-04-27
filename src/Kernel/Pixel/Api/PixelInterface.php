<?php
namespace Picamator\SteganographyKit2\Kernel\Pixel\Api;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;

/**
 * Pixel entity
 *
 * @package Kernel\Pixel
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
    public function setColor(ColorInterface $color): PixelInterface;

    /**
     * Has pixel changed
     *
     * @return bool true if pixel was changed or false otherwise
     */
    public function hasChanged() : bool;
}
