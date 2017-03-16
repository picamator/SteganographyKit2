<?php
namespace Picamator\SteganographyKit2\Kernel\StegoSystem\Api;

use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextInterface;

/**
 * Decode is extracting SecretText from CoverText
 *
 * Actual algorithm's implementation is concentrated inside CoverText, SecretText, StegoText iterators.
 */
interface DecodeInterface
{
    /**
     * Decode
     *
     * @param StegoTextInterface $stegoText
     *
     * @return SecretTextInterface
     */
    public function decode(StegoTextInterface $stegoText) : SecretTextInterface;
}
