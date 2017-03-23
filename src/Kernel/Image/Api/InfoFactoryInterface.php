<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\InfoInterface;

/**
 * Create Info object
 */
interface InfoFactoryInterface
{
    /**
     * Create
     *
     * @param string $path
     *
     * @return InfoInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(string $path) : InfoInterface;
}
