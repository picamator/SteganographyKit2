<?php
namespace Picamator\SteganographyKit2\Kernel\Pixel\Api\Iterator;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface;

/**
 * Create Iterator object
 *
 * @package Kernel\Pixel\Iterator
 */
interface IteratorFactoryInterface
{
    /**
     * Create
     *
     * @param PixelInterface $pixel
     *
     * @return IteratorInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(PixelInterface $pixel) : IteratorInterface;
}
