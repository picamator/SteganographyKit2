<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Image\Api\ChannelFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Channel object
 */
class ChannelFactory implements ChannelFactoryInterface
{
    /**
     * The channels order in array important for encode as well as for decode
     *
     * @var array
     */
    private static $defaultChannels = ['red', 'green', 'blue'];

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
        $className = 'Picamator\SteganographyKit2\Kernel\Image\Data\Channel'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data = []) : ChannelInterface
    {
        if (empty($data)) {
            return $this->objectManager->create($this->className, [self::$defaultChannels]);
        }

        if (!empty(array_diff($data, self::$defaultChannels))) {
            throw new InvalidArgumentException(
                sprintf('Invalid channel list [%s]. Please choose ones form the [%s].',
                    implode(', ' , $data),
                    implode(', ' , self::$defaultChannels)
                )
            );
        }

        return $this->objectManager->create($this->className, [$data]);
    }
}
