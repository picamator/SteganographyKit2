<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

/**
 * Create Repository object
 */
interface RepositoryFactoryInterface
{
    /**
     * Create
     *
     * @param ImageInterface $image
     *
     * @return RepositoryInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(ImageInterface $image) : RepositoryInterface;
}
