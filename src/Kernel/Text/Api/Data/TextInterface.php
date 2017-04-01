<?php
namespace Picamator\SteganographyKit2\Kernel\Text\Api\Data;

/**
 * Text
 *
 * @package Kernel\Text
 */
interface TextInterface extends \Countable
{
    /**
     * Gets text
     *
     * @return string
     */
    public function getText() : string;
}
