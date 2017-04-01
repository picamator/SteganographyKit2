<?php
namespace Picamator\SteganographyKit2\Kernel\Pixel\Api;

use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;

/**
 * Create repository object
 *
 * @package Kernel\Pixel
 */
interface RepositoryFactoryInterface
{
    /**
     * Create
     *
     * @param ResourceInterface $resource
     *
     * @return RepositoryInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(ResourceInterface $resource) : RepositoryInterface;
}
