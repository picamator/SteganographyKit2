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
     * @return \RecursiveIterator
     *
     * @throws \Picamator\SteganographyKit2\Exception\RuntimeException
     */
    public function create(PixelInterface $pixel) : \RecursiveIterator;
}
