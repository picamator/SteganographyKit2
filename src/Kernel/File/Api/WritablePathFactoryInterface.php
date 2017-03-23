<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\WritablePathInterface;

/**
 * Create Writable path value object
 */
interface WritablePathFactoryInterface
{
    /**
     * Generate
     *
     * @param string $path
     *
     * @return WritablePathInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function create(string $path) : WritablePathInterface;
}
