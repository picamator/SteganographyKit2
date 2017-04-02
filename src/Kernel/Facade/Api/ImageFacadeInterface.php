<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api;

/**
 * Facade for all Steganography algorithms where secretText is an image
 *
 * @package Kernel\Facade
 */
interface ImageFacadeInterface
{
    /**
     * Encode
     *
     * @param string $secretPath
     * @param string $coverPath
     *
     * @return string depends on what export strategy is used e.g. base64 string or path to exported file
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function encode(string $secretPath, string $coverPath) : string;

    /**
     * Decode
     *
     * @param string $stegoPath
     *
     * @return string depends on what export strategy is used e.g. base64 string or path to exported file
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function decode(string $stegoPath) : string;
}
