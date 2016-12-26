<?php
namespace Picamator\SteganographyKit2\Entity\Api\Memento;

/**
 * Create pixel memento value object
 */
interface PixelMementoFactoryInterface
{
    /**
     * Create
     *
     * @param array $data
     *
     * @return PixelMementoInterface
     *
     * @throws \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Exception\LogicException
     */
    public function create(array $data) : PixelMementoInterface;
}
