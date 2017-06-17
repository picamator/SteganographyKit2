<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Primitive\Builder;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Data\Point;

/**
 * Create Point object
 *
 * @package Kernel\Primitive
 *
 * @codeCoverageIgnore
 */
final class PointFactory
{
    /**
     * Create
     *
     * @param int $x
     * @param int $y
     *
     * @return PointInterface
     */
    public static function create(int $x, int $y) : PointInterface
    {
        return new Point($x, $y);
    }
}
