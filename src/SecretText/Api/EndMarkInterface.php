<?php
namespace Picamator\SteganographyKit2\SecretText\Api;

/**
 * EndMark is an identifier that secret text was ended
 *
 * It prevents to read all cover/stego text
 */
interface EndMarkInterface extends \IteratorAggregate, \Countable
{
    /**
     * Gets binary
     *
     * @return string binary string, length should be divided by 8
     */
    public function getBinary() : string;
}
