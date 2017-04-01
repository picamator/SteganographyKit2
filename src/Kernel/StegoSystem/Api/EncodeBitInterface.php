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
     * @param string $secretBit
     * @param ByteInterface $coverByte
     *
     * @return ByteInterface
     */
    public function encode(string $secretBit, ByteInterface $coverByte) : ByteInterface;
}
