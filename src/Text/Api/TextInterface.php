<?php
namespace Picamator\SteganographyKit2\Text\Api;

/**
 * Text
 */
interface TextInterface extends \IteratorAggregate
{
    /**
     * Gets size in bits
     *
     * @return int
     */
    public function getLengthBits() : int;

    /**
     * Gets text
     *
     * @return string
     */
    public function getText() : string;
}
