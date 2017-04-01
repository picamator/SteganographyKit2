<?php
namespace Picamator\SteganographyKit2\Kernel\Pixel\Api\Data;

/**
 * Color channel value object
 *
 * @package Kernel\Pixel
 */
interface ChannelInterface extends \Countable
{
    /**
     * Gets channels
     *
     * @return array ['red', 'green', 'blue']
     */
    public function getChannelList() : array;

    /**
     * Gets channel
     *
     * @param int $index
     *
     * @return string
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function getChannel(int $index) : string;

    /**
     * Gets method names based on channel
     *
     * @return array ['getRed', 'getGreen', 'getBlue']
     */
    public function getMethodList() : array;

    /**
     * Gets method
     *
     * @param int $index
     *
     * @return string
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function getMethod(int $index) : string;
}
