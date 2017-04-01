<?php
namespace Picamator\SteganographyKit2\Kernel\StegoSystem\Api;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;

/**
 * Decode one secret bit
 *
 * @package Kernel\StegoSystem
 */
interface DecodeBitInterface
{
    /**
     * Decode
     *
     * @param ByteInterface $stegoByte
     *
     * @return string
     */
    public function decode(ByteInterface $stegoByte) : string;
}
