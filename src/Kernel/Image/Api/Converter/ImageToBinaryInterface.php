<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api\Converter;

use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;

/**
 * Convert image to binary text
 *
 * @package Kernel\Image\Converter
 */
interface ImageToBinaryInterface
{
    /**
     * Convert
     *
     * @param ImageInterface $image
     *
     * @return string
     */
    public function convert(ImageInterface $image) : string;
}
