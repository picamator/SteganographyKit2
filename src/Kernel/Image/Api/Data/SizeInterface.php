<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api\Data;

/**
 * Size value object
 */
interface SizeInterface
{
    /**
     * Gets width
     *
     * @return int
     */
    public function getWidth() : int;

    /**
     * Gets height
     *
     * @return int
     */
    public function getHeight() : int;

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
    public function getChannels() : int;

    /**
     * Gets mime
     *
     * @return string
     */
    public function getMime() : string;
}
