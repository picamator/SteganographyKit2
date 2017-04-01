<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\StegoSystem;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface;
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
 * Sharable helper service. The class is a namespace over methods.
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
     * @var DecodeBitInterface
     */
    private $decodeBit;

    /**
     * @var InfoMarkFactoryInterface
     */
    private $infoMarkFactory;

    /**
     * @var SecretTextFactoryInterface
     */
    private $secretTextFactory;

    /**
     * @param DecodeBitInterface $decodeBit
     * @param InfoMarkFactoryInterface $infoMarkFactory
     * @param SecretTextFactoryInterface $secretTextFactory
     */
    public function __construct(
        DecodeBitInterface $decodeBit,
        InfoMarkFactoryInterface $infoMarkFactory,
        SecretTextFactoryInterface $secretTextFactory
    ) {
        $this->decodeBit = $decodeBit;
        $this->infoMarkFactory = $infoMarkFactory;
        $this->secretTextFactory = $secretTextFactory;
    }

    /**
     * @inheritDoc
     */
    public function decode(StegoTextInterface $stegoText): SecretTextInterface
    {
        $iterator = new \RecursiveIteratorIterator($stegoText); // item is a ByteInterface
        $infoMark = $this->getInfoMark($iterator);
        $maxIndex = $infoMark->countText();

        $limitIterator = new \LimitIterator($iterator, InfoMarkInterface::MARK_COUNT, $maxIndex);

        $secretText = '';
        foreach($limitIterator as $item) {
            $secretText .= $this->decodeBit->decode($item);
        };

        return $this->secretTextFactory->create($infoMark, $secretText);
    }

    /**
     * Gets info mark
     *
     * @param \RecursiveIteratorIterator $iterator
     *
     * @return InfoMarkInterface
     */
    private function getInfoMark(\RecursiveIteratorIterator $iterator) : InfoMarkInterface
    {
        $iterator = new \LimitIterator($iterator, 0, InfoMarkInterface::MARK_COUNT);

        $binaryString = '';
        foreach ($iterator as $item) {
            $binaryString .= $this->decodeBit->decode($item);
        }

        if (strlen($binaryString) < InfoMarkInterface::MARK_COUNT) {
            throw new RuntimeException(
                sprintf('Failed create InfoMark object from binary string "%s". Binary string is shorter then 32 bits.', $binaryString)
            );
        }

        $infoDoubleByte = str_split($binaryString, InfoMarkInterface::MARK_COUNT / 2);
        $infoDoubleByte = array_map('bindec', $infoDoubleByte);

        return $this->infoMarkFactory->create($infoDoubleByte[0], $infoDoubleByte[1]);
    }
}
