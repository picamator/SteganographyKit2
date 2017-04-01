<?php
namespace Picamator\SteganographyKit2\Kernel\Pixel\Api\Data;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;

/**
 * Color value object
 *
 * @package Kernel\Pixel
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

    /**
     * To string
     *
     * @return string
     */
    public function toString() : string;

    /**
     * To array
     *
     * @return array
     */
    public function toArray() : array;
}
