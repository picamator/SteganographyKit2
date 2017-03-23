<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;

/**
 * Resource image implementation for different image types
 *
 * It's part of Bridge pattern between Abstraction "Image" and "Resource" implementation.
 * It helps to extend application with different image type.
 *
 * @package Kernel\Image
 */
interface ResourceInterface
{
    /**
     * Gets name
     *
     * @return string
     */
    public function getName() : string;

    /**
     * Gets size
     *
     * @return SizeInterface
     */
    public function getSize() : SizeInterface;

    /**
     * Gets resource
     *
     * @return resource
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function getResource();
}
