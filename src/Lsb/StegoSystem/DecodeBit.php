<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Lsb\StegoSystem;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Api\DecodeBitInterface;

/**
 * Decode one secret bit
 *
 * Extract Least Significant Bit.
 *
 * Class type
 * ----------
 * Sharable helper service. The class is an namespace over methods.
 *
 * Responsibility
 * --------------
 * Decode one bit
 *
 * State
 * -----
 * No state
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor method.
 *
 * Check list
 * ----------
 * * Single responsibility ``+``
 * * Tell don't ask ``-``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
 *
 * @package Lsb\StegoSystem
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
