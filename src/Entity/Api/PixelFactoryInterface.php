<?php
namespace Picamator\SteganographyKit2\Entity\Api;

use Picamator\SteganographyKit2\Entity\PixelInterface;

/**
 * Create Pixel entity
 */
interface PixelFactoryInterface
{
    /**
     * Create
     *
     * @param array $data
     *
     * @return mixed
     *
     * @throws \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Exception\LogicException
     */
    public function create(array $data) : PixelInterface;
}
