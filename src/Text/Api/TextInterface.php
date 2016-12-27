<?php
namespace Picamator\SteganographyKit2\Text;

/**
 * Text
 */
interface TextInterface extends \IteratorAggregate
{
    /**
     * Gets size
     *
     * @return int
     */
    public function getSize() : int;

    /**
     * Gets text
     *
     * @return string
     */
    public function getText() : string;
}
