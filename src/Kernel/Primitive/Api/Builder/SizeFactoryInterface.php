<?php
namespace Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;

/**
 * Create Size object
 *
 * @package Kernel\Primitive
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
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(int $width, int $height) : SizeInterface;
}
