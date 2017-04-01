<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api\Data;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;

/**
 * Info value object
 *
 * @package Kernel\File
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
     * Gets attributes
     *
     * @return int
     */
    public function getType() : int;

    /**
     * Gets bits
     *
     * @return int
     */
    public function getBits() : int;

    /**
     * Get channels
     *
     * @return int
     */
    public function getChannels() : int;

    /**
     * Gets mime
     *
     * @return string
     */
    public function getMime() : string;

    /**
     * Gets name
     *
     * @return string
     */
    public function getName() : string;

    /**
     * Gets path
     *
     * @return string
     */
    public function getPath() : string;
}
