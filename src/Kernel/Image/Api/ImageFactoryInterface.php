<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryInterface;

/**
 * Create image object
 *
 * @package Kernel\Imageґ\Resource
 */
interface ImageFactoryInterface
{
    /**
     * Create image
     *
     * @param RepositoryInterface $repository
     *
     * @return ImageInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function createImage(RepositoryInterface $repository) : ImageInterface;

    /**
     * Create palette image
     *
     * @param InfoInterface $info
     *
     * @return ImageInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function createPaletteImage(InfoInterface $info) : ImageInterface;
}
