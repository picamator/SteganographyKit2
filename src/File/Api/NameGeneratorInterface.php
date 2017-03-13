<?php
namespace Picamator\SteganographyKit2\File\Api;

use Picamator\SteganographyKit2\Exception\InvalidArgumentException;

/**
 * Strategy to generate file name
 */
interface NameGeneratorInterface
{
    /**
     * Generate
     *
     * @param string $path
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function generate(string $path) : string;
}
