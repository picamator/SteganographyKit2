<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api;

/**
 * Strategy to generate file name
 */
interface NameGeneratorInterface
{
    /**
     * Generate
     *
     * @param string $sourceName
     *
     * @return string
     */
    public function generate(string $sourceName) : string;
}
