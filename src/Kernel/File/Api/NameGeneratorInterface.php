<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api;

/**
 * Strategy to generate file name
 *
 * @package Kernel\File
 */
interface NameGeneratorInterface
{
    /**
     * Generate
     *
     * @param string $sourceName
     * @param string $extension
     *
     * @return string
     */
    public function generate(string $sourceName, string $extension) : string;
}
