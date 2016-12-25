<?php
namespace Picamator\SteganographyKit2\Entity;

use Picamator\SteganographyKit2\Entity\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;

/**
 * Create Pixel object
 *
 * @codeCoverageIgnore
 */
class PixelFactory implements PixelFactoryInterface
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
        $className = 'Picamator\SteganographyKit2\Entity\Pixel'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data) : PixelInterface
    {
        return $this->objectManager->create($this->className, [$data]);
    }
}
