<?php
namespace Picamator\SteganographyKit2\Primitive;

use Picamator\SteganographyKit2\Primitive\Api\ByteFactoryInterface;
use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;

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
        $className = 'Picamator\SteganographyKit2\Primitive\Data\Byte'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data) : ByteInterface
    {
        return $this->objectManager->create($this->className, [$data]);
    }
}
