<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;

/**
 * Create image object
 *
 * @package Kernel\Imageґ\Resource
 */
interface ImageFactoryInterface
{
    /**
     * Create
     *
     * @param InfoInterface $info
     *
     * @return ImageInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(InfoInterface $info) : ImageInterface;
}
