<?php
namespace Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface;

/**
 * Create Color object
 *
 * @package Kernel\Pixel
 */
interface ColorFactoryInterface
{
    /**
     * Create
     *
     * @param array $data
     *
     * @return ColorInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(array $data) : ColorInterface;
}
