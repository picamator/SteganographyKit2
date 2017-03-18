<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Entity\Iterator;

use Picamator\SteganographyKit2\Kernel\Entity\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Iterator object
 *
 * @codeCoverageIgnore
 */
class IteratorFactory implements IteratorFactoryInterface
{
    /**
     * @var array
     */
    private static $channels = ['red', 'green', 'blue'];

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var Channel
     */
    private $iteratedChannels;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ChannelInterface $iteratedChannels
     * @param string $className
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ChannelInterface $iteratedChannels,
        string $className = 'Picamator\SteganographyKit2\Kernel\Entity\Iterator\SerialIterator'
    ) {
        $this->objectManager = $objectManager;
        $this->iteratedChannels = $iteratedChannels;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function create(PixelInterface $pixel) : \RecursiveIterator
    {
        return $this->objectManager->create($this->className, [$pixel, $this->iteratedChannels]);
    }
}
