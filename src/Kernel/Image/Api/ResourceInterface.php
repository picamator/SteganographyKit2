<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

/**
 * Resource image implementation for different image types
 *
 * It's part of Bridge pattern between Abstraction "Image" and "Resource" implementation
 * It helps to extend application with different image type
 */
interface ResourceInterface
{
    /**
     * Gets path
     *
     * @return string
     */
    public function getPath() : string;

    /**
     * Gets resource
     *
     * @return resource
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function getResource();
}
