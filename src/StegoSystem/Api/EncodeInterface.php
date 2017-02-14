<?php
namespace Picamator\SteganographyKit2\StegoSystem\Api;

use Picamator\SteganographyKit2\CoverText\Api\CoverTextInterface;
use Picamator\SteganographyKit2\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\StegoText\Api\StegoTextInterface;

/**
 * Encode is converting SecretText and CoverText to StegoText
 *
 * Actual algorithm's implementation is concentrated inside CoverText, SecretText, StegoText iterators and EncodeBit
 */
interface EncodeInterface
{
    /**
     * Encode
     *
     * @param SecretTextInterface $secretText
     * @param CoverTextInterface $coverText
     *
     * @return StegoTextInterface
     */
    public function encode(SecretTextInterface $secretText, CoverTextInterface $coverText) : StegoTextInterface;
}
