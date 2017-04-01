<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Primitive\Builder;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\PointFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Point object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Create ``Point``.
 *
 * State
 * -----
 * No state
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor argument.
 *
 * @package Kernel\Primitive
 *
 * @codeCoverageIgnore
 */
final class PointFactory implements PointFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        string $className = 'Picamator\SteganographyKit2\Kernel\Primitive\Data\Point'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(int $x, int $y) : PointInterface
    {
        return $this->objectManager->create($this->className, [$x, $y]);
    }
}
