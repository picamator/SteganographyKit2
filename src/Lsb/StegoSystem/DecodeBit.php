<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Lsb\StegoSystem;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Api\DecodeBitInterface;

/**
 * Decode one secret bit
 *
 * Extract Least Significant Bit
 */
class DecodeBit implements DecodeBitInterface
{
    /**
     * @inheritDoc
     */
    public function decode(ByteInterface $stegoByte): int
    {
        $secretBit = substr($stegoByte->getBinary(), -1, 1);

        return intval($secretBit);
    }
}
