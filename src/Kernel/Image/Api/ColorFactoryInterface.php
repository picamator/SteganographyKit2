<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;

/**
 * Create Color object
 *
 * @package Kernel\Image
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
