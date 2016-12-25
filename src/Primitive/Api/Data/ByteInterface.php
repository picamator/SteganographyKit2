<?php
namespace Picamator\SteganographyKit2\Primitive\Api\Data;

/**
 * Byte value object
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
