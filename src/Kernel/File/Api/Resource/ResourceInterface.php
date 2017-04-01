<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api\Resource;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;

/**
 * Resource image implementation for different image types
 *
 * It's part of Bridge pattern between Abstraction "Image" and "Resource" implementation.
 * It helps to extend application with different image type.
 *
 * @package Kernel\File\Resource
 */
interface ResourceInterface
{
    /**
     * Gets size
     *
     * @return InfoInterface
     */
    public function getInfo() : InfoInterface;

    /**
     * Gets resource
     *
     * @return resource
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function getResource();
}
