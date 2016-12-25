<?php
namespace Picamator\SteganographyKit2\Primitive\Api;

use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;

/**
 * Create Byte object
 */
interface ByteFactoryInterface
{
    /**
     * Create
     *
     * @param array $data
     *
     * @return ByteInterface
     *
     * @throws \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     */
    public function create(array $data) : ByteInterface;
}
