<?php
namespace Picamator\SteganographyKit2\Kernel\Entity\Api;

use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;

/**
 * Create Pixel repository object
 *
 * @package Kernel\Entity
 */
interface PixelRepositoryFactoryInterface
{
    /**
     * Create
     *
     * @param ResourceInterface $resource
     *
     * @return PixelRepositoryInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(ResourceInterface $resource) : PixelRepositoryInterface;
}
