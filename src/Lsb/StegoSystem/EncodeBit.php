<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Lsb\StegoSystem;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\ByteFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Api\EncodeBitInterface;

/**
 * Encode one secret bit
 *
 * Replace Least Significant Bit by secret one.
 *
 *  * Class type
 * ----------
 * Sharable helper service. The class is an namespace over methods.
 *
 * Responsibility
 * --------------
 * Encode one bit
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
final class EncodeBit implements EncodeBitInterface
{
    /**
     * @var ByteFactoryInterface
     */
    private $byteFactory;

    /**
     * @param ByteFactoryInterface $byteFactory
     */
    public function __construct(ByteFactoryInterface $byteFactory)
    {
       $this->byteFactory = $byteFactory;
    }

    /**
     * @inheritDoc
     */
    public function encode(string $secretBit, ByteInterface $coverByte): ByteInterface
    {
        // skip creating new object if nothing to update
        // it's 60% faster then substr($stegoByte->getBinary(), -1, 1) === $secretBit; Tested on 10000000 iterations.
        $coverBit = $coverByte->getInt() & 1;
        if($coverBit === (int) $secretBit) {
            return $coverByte;
        }

        // it's 15% faster then ``$secretByte = (($coverByte->getInt() >> 1) << 1) + $secretBit; $secretByte = decbin($secretByte);``
        // the same as ``$secretByte = decbin($coverByte->getInt() >> 1) . $secretBit;``
        $secretByte = substr_replace($coverByte->getBinary(), $secretBit, -1);

        return $this->byteFactory->create($secretByte);
    }
}
