<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Primitive;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\PointFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Point object
 *
 * @codeCoverageIgnore
 */
class PointFactory implements PointFactoryInterface
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
    public function create(array $data) : PointInterface
    {
        $x = $data['x'] ?? 0;
        $y = $data['y'] ?? 0;

        return $this->objectManager->create($this->className, [$x, $y]);
    }
}
