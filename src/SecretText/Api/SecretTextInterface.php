<?php
namespace Picamator\SteganographyKit2\SecretText\Api;

/**
 * SecretText is an information for hide or protection signature
 */
interface SecretTextInterface extends \IteratorAggregate
{
    /**
     * Gets source
     *
     * @return string | resource
     */
    public function getResource();

    /**
     * Gets size in bits
     *
     * @return int
     */
    public function getLengthBits() : int;
}
