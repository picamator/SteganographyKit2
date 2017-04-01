<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Primitive\Data;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;

/**
 * Point value object
 *
 * Use composition to extend value object. Don't run ``__construct`` directly to modify object.
 * Protection to run ``__construct`` twice was not added for performance reason supposing the client code has height level of trust.
 *
 * @package Kernel\Primitive
 *
 * @codeCoverageIgnore
 */
final class Point implements PointInterface
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
