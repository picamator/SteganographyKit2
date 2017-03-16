<?php
namespace Picamator\SteganographyKit2\Kernel\Text\Api\Data;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;

/**
 * Ascii value object
 */
interface AsciiInterface
{
    /**
     * Gets char
     *
     * @return string
     */
    public function getChar() : string;

    /**
     * Gets byte
     *
     * @return ByteInterface
     */
    public function getByte() : ByteInterface;
}
