<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api\Iterator;

use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;

/**
 * Create Iterator object
 *
 * @package Kernel\Image\Iterator
 */
interface IteratorFactoryInterface
{
    /**
     * Create
     *
     * @param ResourceInterface $resource
     *
     * @return \Iterator
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(ResourceInterface $resource) : \Iterator;
}
