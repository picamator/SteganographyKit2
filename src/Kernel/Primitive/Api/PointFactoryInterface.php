<?php
namespace Picamator\SteganographyKit2\Kernel\Primitive\Api;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;

/**
 * Create Point object
 *
 * @package Kernel\Primitive
 */
interface PointFactoryInterface
{
    /**
     * Create
     *
     * @param array $data
     *
     * @return PointInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\LogicException
     */
    public function create(array $data) : PointInterface;
}
