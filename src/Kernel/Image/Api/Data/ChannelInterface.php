<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api\Data;

/**
 * Color channel value object
 */
interface ChannelInterface extends \Countable
{
    /**
     * Gets channels
     *
     * @return array ['red', 'green', 'blue']
     */
    public function getChannels() : array;

    /**
     * Gets method names based on channel
     *
     * @return array ['getRed', 'getGreen', 'getBlue']
     */
    public function getMethodChannels() : array;
}
