<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api\Data;

/**
 * Info value object
 *
 * @package Kernel\Image
 */
interface InfoInterface
{
    /**
     * Gets size
     *
     * @return SizeInterface
     */
    public function getSize() : SizeInterface;

    /**
     * Gets attributes
     *
     * @return string
     */
    public function getAttr() : string;

    /**
     * Gets bits
     *
     * @return string
     */
    public function getBits() : string;

    /**
     * Get channels
     *
     * @return int
     */
    public function getCountChannels() : int;

    /**
     * Gets mime
     *
     * @return string
     */
    public function getMime() : string;

    /**
     * Gets extra information
     *
     * @return array parsed IPTC (International Press Telecommunications Council) blocks
     */
    public function getIptc() : array;

    /**
     * Gets extra information
     *
     * @return array
     */
    public function getExtraInfo() : array;
}
