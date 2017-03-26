<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

/**
 * Convert binary string to resource
 *
 * @package Kernel\Image\Converter
 */
interface ConverterInterface
{
    /**
     * Convert
     *
     * Method modifies image's resource by ``$binaryText``
     *
     * @param ImageInterface $image
     * @param string $binaryText
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function convert(ImageInterface $image, string $binaryText);
}
