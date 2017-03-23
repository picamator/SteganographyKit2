<?php
namespace Picamator\SteganographyKit2\Kernel\Primitive\Api\Data;

/**
 * Byte value object
 *
 * @package Kernel\Primitive
 */
interface ByteInterface
{
    /**
     * Gets string
     *
     * @return string
     */
    public function getBinary() : string;

    /**
     * Gets integer
     *
     * @return int
     */
    public function getInt() : int;
}
