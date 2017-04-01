<?php
namespace Picamator\SteganographyKit2\Kernel\SecretText\Api;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;

/**
 * Information marker
 *
 * @package Kernel\SecretText
 */
interface InfoMarkInterface extends \IteratorAggregate
{
    const MAX_SIZE_VALUE = 65535;

    const MARK_COUNT = 32;

    /**
     * Gets size
     *
     * @return SizeInterface
     */
    public function getSize() : SizeInterface;

    /**
     * Gets binary
     *
     * @return string
     */
    public function getBinary() : string;

    /**
     * Counts text
     *
     * @return int
     */
    public function countText() : int;
}
