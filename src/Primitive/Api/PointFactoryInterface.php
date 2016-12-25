<?php
namespace Picamator\SteganographyKit2\Primitive\Api;

use Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface;

/**
 * Create Point object
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
     * @throws \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Exception\LogicException
     */
    public function create(array $data) : PointInterface;
}
