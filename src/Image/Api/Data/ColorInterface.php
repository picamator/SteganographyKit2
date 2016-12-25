<?php
namespace Picamator\SteganographyKit2\Image\Api\Data;

use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;

/**
 * Color value object
 */
interface ColorInterface
{
    /**
     * Gets red channel
     *
     * @return ByteInterface
     */
    public function getRed() : ByteInterface;

    /**
     * Gets green channel
     *
     * @return ByteInterface
     */
    public function getGreen() : ByteInterface;

    /**
     * Gets blue channel
     *
     * @return ByteInterface
     */
    public function getBlue() : ByteInterface;

    /**
     * Gets alpha channel
     *
     * @return ByteInterface
     */
    public function getAlpha() : ByteInterface;
}
