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
     * @return array
     */
    public function getChannels() : array;
}
