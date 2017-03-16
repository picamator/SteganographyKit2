<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Lsb\StegoSystem;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\ByteFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Api\EncodeBitInterface;

/**
 * Encode one secret bit
 *
 * Replace Least Significant Bit by secret one
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
