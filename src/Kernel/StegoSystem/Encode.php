<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\StegoSystem;

use Picamator\SteganographyKit2\Kernel\CoverText\Api\CoverTextInterface;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Api\EncodeBitInterface;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Api\EncodeInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextFactoryInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextInterface;

/**
 * Encode is converting SecretText and CoverText to StegoText
 *
 * Actual algorithm's implementation is concentrated inside CoverText, SecretText, StegoText iterators.
 *
 * Class type
 * ----------
 * Sharable helper service. The class is a namespace over methods.
 *
 * Responsibility
 * --------------
 * Encode ``SecretText``.
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
class Encode implements EncodeInterface
{
    /**
     * @var EncodeBitInterface
     */
    private $encodeBit;

    /**
     * @var StegoTextFactoryInterface
     */
    private $stegoTextFactory;

    /**
     * @param EncodeBitInterface $encodeBit
     * @param StegoTextFactoryInterface $stegoTextFactory
     */
    public function __construct(
        EncodeBitInterface $encodeBit,
        StegoTextFactoryInterface $stegoTextFactory
    ) {
        $this->encodeBit = $encodeBit;
        $this->stegoTextFactory = $stegoTextFactory;
    }

    /**
     * @inheritDoc
     */
    public function encode(SecretTextInterface $secretText, CoverTextInterface $coverText): StegoTextInterface
    {
        $repository = $coverText->getImage()->getRepository();
        $iterator = new \MultipleIterator(\MultipleIterator::MIT_NEED_ALL | \MultipleIterator::MIT_KEYS_ASSOC);

        // secret text iterator
        $secretIterator = new \CachingIterator($secretText->getIterator());
        $iterator->attachIterator($secretIterator, 'secretBit');

        // cover text iterator (0) PixelInterface -> (1) ByteInterface
        $coverIterator = new \RecursiveIteratorIterator($coverText);
        $iterator->attachIterator($coverIterator, 'coverByte');

        $prevPixel = $coverIterator->getSubIterator(0)->current();
        foreach ($iterator as $item) {
            // encode bit
            $stegoByte = $this->encodeBit->encode($item['secretBit'], $item['coverByte']);

            // update pixel
            $colorKey = $coverIterator->getSubIterator(1)->key();
            if (isset($colorList[$colorKey])) {
                $repository->update($prevPixel, $colorList);
                $colorList = [];
            }

            $colorList[$colorKey] = $stegoByte;

            // last iteration
            if (!$secretIterator->hasNext()) {
                $repository->update($coverIterator->getSubIterator(0)->current(), $colorList);
            }

            $prevPixel = $coverIterator->getSubIterator(0)->current();
        }

        return $this->stegoTextFactory->create($coverText->getImage());
    }
}
