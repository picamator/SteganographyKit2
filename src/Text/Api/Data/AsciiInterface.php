<?php
namespace Picamator\SteganographyKit2\Text\Data;

use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;

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
