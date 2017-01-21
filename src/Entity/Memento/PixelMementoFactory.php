<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Entity\Memento;

use Picamator\SteganographyKit2\Entity\Api\Memento\PixelMementoFactoryInterface;
use Picamator\SteganographyKit2\Entity\Api\Memento\PixelMementoInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;

/**
 * Pixel memento
 *
 * @codeCoverageIgnore
 */
class PixelMementoFactory implements PixelMementoFactoryInterface
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
        $className = 'Picamator\SteganographyKit2\Entity\Memento\PixelMemento'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data) : PixelMementoInterface
    {
        return $this->objectManager->create($this->className, [$data]);
    }
}
