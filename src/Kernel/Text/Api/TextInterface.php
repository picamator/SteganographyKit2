<?php
namespace Picamator\SteganographyKit2\Kernel\Text\Api;

/**
 * Text
 *
 * @package Kernel\Text
 */
interface TextInterface extends \IteratorAggregate
{
    /**
     * Gets bit count
     *
     * @return int
     */
    public function getCountBit() : int;

    /**
     * Gets text
     *
     * @return string
     */
    public function getText() : string;
}
