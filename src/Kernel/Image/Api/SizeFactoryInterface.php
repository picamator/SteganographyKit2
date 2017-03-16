<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;

/**
 * Create Size object
 */
interface SizeFactoryInterface
{
    /**
     * Create
     *
     * @param string $path
     *
     * @return SizeInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(string $path) : SizeInterface;
}
