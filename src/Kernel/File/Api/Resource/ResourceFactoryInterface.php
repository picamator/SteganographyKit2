<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api\Resource;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;

/**
 * Create resource object
 *
 * @package Kernel\File\Resource
 */
interface ResourceFactoryInterface
{
    /**
     * Create jpeg resource
     *
     * @param InfoInterface $info
     *
     * @return ResourceInterface
     */
    public function createJpegResource(InfoInterface $info) : ResourceInterface;

    /**
     * Create png resource
     *
     * @param InfoInterface $info
     *
     * @return ResourceInterface
     */
    public function createPngResource(InfoInterface $info) : ResourceInterface;

    /**
     * Create palette resource
     *
     * @param InfoInterface $info
     *
     * @return ResourceInterface
     */
    public function createPaletteResource(InfoInterface $info) : ResourceInterface;
}
