<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Lsb\StegoSystem;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\ByteFactoryInterface;
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
class EncodeBit implements EncodeBitInterface
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
    public function encode(int $secretBit, ByteInterface $coverByte): ByteInterface
    {
        $secretByte = substr_replace($coverByte->getBinary(), $secretBit, -1);

        return $this->byteFactory->create($secretByte);
    }
}
