<?php
namespace Picamator\SteganographyKit2\StegoSystem\Api;

use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;

/**
 * Decode one secret bit
 */
interface DecodeBitInterface
{
    /**
     * Decode
     *
     * @param ByteInterface $stegoByte
     *
     * @return int
     */
    public function decode(ByteInterface $stegoByte) : int;
}
