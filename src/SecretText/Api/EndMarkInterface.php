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
     * To string
     *
     * @return string
     */
    public function toString() : string;
}
