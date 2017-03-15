<?php
namespace Picamator\SteganographyKit2\Image\Api\Iterator;

use Picamator\SteganographyKit2\Image\Api\ImageInterface;

/**
 * Create Iterator object
 */
interface IteratorFactoryInterface
{
    /**
     * Create
     *
     * @param ImageInterface $image
     *
     * @return \Iterator
     *
     * @throws \Picamator\SteganographyKit2\Exception\RuntimeException
     */
    public function create(ImageInterface $image) : \Iterator;
}
