<?php
namespace Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder;

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
     * @param int $x
     * @param int $y
     *
     * @return PointInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\LogicException
     */
    public function create(int $x, int $y) : PointInterface;
}
