<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;

/**
 * Create Size object
 *
 * @package Kernel\Image
 */
interface SizeFactoryInterface
{
    /**
     * Create
     *
     * @param int $width
     * @param int $height
     *
     * @return SizeInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(int $width, int $height) : SizeInterface;
}
