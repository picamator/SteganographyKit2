<?php
namespace Picamator\SteganographyKit2\Kernel\Text\Api\Data;

/**
 * Length value object
 *
 * It's moved as a separate object in case for multibyte string.
 *
 * @package Kernel\Text
 */
interface LengthInterface
{
    /**
     * Gets length
     *
     * @return int
     */
    public function getLength() : int;

    /**
     * Gets bit count
     *
     * @return int
     */
    public function getCountBit() : int;
}
