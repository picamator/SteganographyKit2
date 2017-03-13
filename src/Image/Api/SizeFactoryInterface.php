<?php
namespace Picamator\SteganographyKit2\Image\Api;

use Picamator\SteganographyKit2\Image\Api\Data\SizeInterface;

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
     * @throws \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Exception\LogicException
     * @throws \Picamator\SteganographyKit2\Exception\RuntimeException
     */
    public function create(string $path) : SizeInterface;
}
