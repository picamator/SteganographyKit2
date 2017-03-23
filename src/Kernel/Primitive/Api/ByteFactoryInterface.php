<?php
namespace Picamator\SteganographyKit2\Kernel\Primitive\Api;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;

/**
 * Create Byte object
 *
 * @package Kernel\Primitive
 */
interface ByteFactoryInterface
{
    /**
     * Create
     *
     * @param string $byte
     *
     * @return ByteInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function create(string $byte) : ByteInterface;
}
