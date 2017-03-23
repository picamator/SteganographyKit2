<?php
namespace Picamator\SteganographyKit2\Kernel\SecretText\Api;

/**
 * SecretText is an information for hide or protection signature
 *
 * @package Kernel\SecretText
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
     * Gets bit count
     *
     * @return int
     */
    public function getCountBit() : int;
}
