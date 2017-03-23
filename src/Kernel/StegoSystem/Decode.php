<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\StegoSystem;

use Picamator\SteganographyKit2\Kernel\SecretText\Api\EndMarkInterface;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Api\DecodeBitInterface;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Api\DecodeInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextInterface;

/**
 * Decode is extracting SecretText from CoverText
 *
 * Actual algorithm's implementation is concentrated inside CoverText, SecretText, StegoText iterators.
 *
 * Class type
 * ----------
 * Sharable helper service. The class is an namespace over methods.
 *
 * Responsibility
 * --------------
 * Decode ``SecretText``.
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
 * @package Kernel\StegoSystem
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
        while (substr($secretText, $endMarkPos) !== $endMark && $iterator->valid()) {
            $secretText .= $this->decodeBit->decode($iterator->current());
            $iterator->next();
        };

        // remove end text mark
        $secretText = substr($secretText, 0, strlen($secretText) - $this->endMark->count());

        return $this->secretTextFactory->create($secretText);
    }
}
