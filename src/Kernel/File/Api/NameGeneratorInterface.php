<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;

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
