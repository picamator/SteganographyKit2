<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api\Converter;

use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;

/**
 * Convert binary text to image
 *
 * @package Kernel\Image\Converter
 */
interface BinaryToImageInterface
{
    /**
     * Convert
     *
     * @param SizeInterface $size
     * @param string $binaryText
     *
     * @return ImageInterface
     */
    public function convert(SizeInterface $size, string $binaryText) : ImageInterface;
}
