<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Primitive;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\ByteFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Byte object
 *
 * @codeCoverageIgnore
 */
class ByteFactory implements ByteFactoryInterface
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
        string $className = 'Picamator\SteganographyKit2\Kernel\Primitive\Data\Byte'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(string $byte) : ByteInterface
    {
        return $this->objectManager->create($this->className, [$byte]);
    }
}
