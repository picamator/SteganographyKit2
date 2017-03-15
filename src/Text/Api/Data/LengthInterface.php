<?php
namespace Picamator\SteganographyKit2\Text\Api\Data;

/**
 * Length value object
 *
 * It's moved as a separate object in case for multibyte string
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
     * Gets length in bits
     *
     * @return int
     */
    public function getLengthBits() : int;
}
