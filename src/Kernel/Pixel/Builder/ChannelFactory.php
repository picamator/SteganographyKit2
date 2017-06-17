<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Pixel\Builder;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Data\Channel;

/**
 * Create Channel object
 *
 * @package Kernel\Pixel
 */
final class ChannelFactory
{
    /**
     * The channels order in array important for encode as well as for decode
     *
     * @var array
     */
    private static $defaultChannels = ['red', 'green', 'blue'];

    /**
     * @inheritDoc
     */
    public static function create(array $data = []) : ChannelInterface
    {
        if (empty($data)) {
            return new Channel(self::$defaultChannels);
        }

        if (!empty(array_diff($data, self::$defaultChannels))) {
            throw new InvalidArgumentException(
                sprintf('Invalid channel list [%s]. Please choose ones form the [%s].',
                    implode(', ' , $data),
                    implode(', ' , self::$defaultChannels)
                )
            );
        }

        return new Channel($data);
    }
}
