<?php
namespace Picamator\SteganographyKit2\Kernel\StegoSystem\Api;

use Picamator\SteganographyKit2\Kernel\CoverText\Api\CoverTextInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextInterface;

/**
 * Encode is converting SecretText and CoverText to StegoText
 *
 * Actual algorithm's implementation is concentrated inside CoverText, SecretText, StegoText iterators and EncodeBit.
 *
 * @package Kernel\StegoSystem
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
