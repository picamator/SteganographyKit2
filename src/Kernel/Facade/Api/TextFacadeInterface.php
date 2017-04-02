<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api;

/**
 * Facade for all Steganography algorithms where secretText is a plain text
 *
 * @package Kernel\Facade
 */
interface TextFacadeInterface
{
    /**
     * Encode
     *
     * @param string $secretText
     * @param string $coverPath
     *
     * @return string result depends on what export strategy is used e.g. base64 string or path to exported file
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function encode(string $secretText, string $coverPath) : string;

    /**
     * Decode
     *
     * @param string $stegoPath
     *
     * @return string
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function decode(string $stegoPath) : string;
}
