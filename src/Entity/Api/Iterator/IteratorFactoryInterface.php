<?php
namespace Picamator\SteganographyKit2\Entity\Api\Iterator;

use Picamator\SteganographyKit2\Entity\Api\PixelInterface;

/**
 * Create Iterator object
 */
interface IteratorFactoryInterface
{
    /**
     * Create
     *
     * @param PixelInterface $pixel
     *
     * @return \Iterator
     *
     * @throws \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Exception\LogicException
     */
    public function create(PixelInterface $pixel) : \Iterator;
}
