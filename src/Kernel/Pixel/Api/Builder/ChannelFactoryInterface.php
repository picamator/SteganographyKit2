<?php
namespace Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface;

/**
 * Create Channel object
 *
 * @package Kernel\Pixel
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
