<?php
namespace Picamator\SteganographyKit2\Entity\Api;

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
     * @return PixelInterface
     *
     * @throws \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Exception\LogicException
     */
    public function create(array $data) : PixelInterface;
}
