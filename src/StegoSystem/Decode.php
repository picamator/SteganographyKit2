<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\StegoSystem;

use Picamator\SteganographyKit2\SecretText\Api\EndMarkInterface;
use Picamator\SteganographyKit2\StegoSystem\Api\DecodeBitInterface;
use Picamator\SteganographyKit2\StegoSystem\Api\DecodeInterface;
use Picamator\SteganographyKit2\SecretText\Api\SecretTextFactoryInterface;
use Picamator\SteganographyKit2\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\StegoText\Api\StegoTextInterface;

/**
 * Decode is extracting SecretText from CoverText
 *
 * Actual algorithm's implementation is concentrated inside CoverText, SecretText, StegoText iterators.
 */
class Decode implements DecodeInterface
{
    /**
     * @var SecretTextFactoryInterface
     */
    private $secretTextFactory;

    /**
     * @var DecodeBitInterface
     */
    private $decodeBit;

    /**
     * @var EndMarkInterface
     */
    private $endMark;

    /**
     * @param SecretTextFactoryInterface $secretTextFactory
     * @param DecodeBitInterface $decodeBit
     * @param EndMarkInterface $endMark
     */
    public function __construct(
        SecretTextFactoryInterface $secretTextFactory,
        DecodeBitInterface $decodeBit,
        EndMarkInterface $endMark
    ) {
        $this->secretTextFactory = $secretTextFactory;
        $this->decodeBit = $decodeBit;
        $this->endMark = $endMark;
    }

    /**
     * @inheritDoc
     */
    public function decode(StegoTextInterface $stegoText): SecretTextInterface
    {
        $iterator = new \RecursiveIteratorIterator($stegoText); // item is a ByteInterface
        $iterator->rewind();

        $endMark = $this->endMark->getBinary();
        $endMarkPos = -1 * $this->endMark->count();

        $secretText = '';
        do {
            $secretText .= $this->decodeBit->decode($iterator->current());
            $iterator->next();
        } while (substr($secretText, $endMarkPos) !== $endMark && $iterator->valid());

        return $this->secretTextFactory->create($secretText);
    }
}
