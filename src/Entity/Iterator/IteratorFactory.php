<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Entity\Iterator;

use Picamator\SteganographyKit2\Entity\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;

/**
 * Create Iterator object
 *
 * @codeCoverageIgnore
 */
class IteratorFactory implements IteratorFactoryInterface
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
        string $className = 'Picamator\SteganographyKit2\Entity\Iterator\SerialIterator'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(PixelInterface $pixel) : \RecursiveIterator
    {
        return $this->objectManager->create($this->className, [$pixel]);
    }
}
