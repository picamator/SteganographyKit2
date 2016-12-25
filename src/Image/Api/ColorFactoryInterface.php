<?php
namespace Picamator\SteganographyKit2\Image\Api;

use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;

/**
 * Create Color object
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
     * @throws \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Exception\LogicException
     */
    public function create(array $data) : ColorInterface;
}
