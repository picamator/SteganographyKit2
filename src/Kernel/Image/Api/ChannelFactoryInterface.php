<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface;

/**
 * Create Channel object
 */
interface ChannelFactoryInterface
{
    /**
     * Create
     *
     * @param array $data
     *
     * @return ChannelInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function create(array $data) : ChannelInterface;
}
