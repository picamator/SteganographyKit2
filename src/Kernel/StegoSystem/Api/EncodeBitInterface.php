<?php
namespace Picamator\SteganographyKit2\Kernel\StegoSystem\Api;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;

/**
 * Encode one secret bit
 *
 * @package Kernel\StegoSystem
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
