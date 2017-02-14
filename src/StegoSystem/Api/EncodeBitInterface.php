<?php
namespace Picamator\SteganographyKit2\StegoSystem\Api;

use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;

/**
 * Encode one secret bit
 */
interface EncodeBitInterface
{
    /**
     * Encode
     *
     * @param int $secretBit
     * @param ByteInterface $coverByte
     *
     * @return ByteInterface
     */
    public function encode(int $secretBit, ByteInterface $coverByte) : ByteInterface;
}
