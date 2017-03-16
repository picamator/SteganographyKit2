<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Primitive\Data;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;

/**
 * Point value object
 *
 * Use factory for building objects to avoid using constructor argument wrong order
 *
 * @codeCoverageIgnore
 */
class Point implements PointInterface
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @inheritDoc
     */
    public function getX() : int
    {
        return $this->x;
    }

    /**
     * @inheritDoc
     */
    public function getY() : int
    {
       return $this->y;
    }
}
