<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Data;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface;

/**
 * Color channel value object
 */
class Channel implements ChannelInterface
{
    /**
     * The channels order in array important for encode as well as for decode
     *
     * @var array
     */
    private static $defaultChannels = ['red', 'green', 'blue'];

    /**
     * @var array
     */
    private $channels;

    /**
     * @var int
     */
    private $countChannels;

    /**
     * @var array
     */
    private $methodChannels;

    /**
     * @param array $channels The channels order in array important for encode as well as for decode
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $channels = [])
    {
        $this->setChannels($channels);
        $this->setMethodChannels($this->channels);

        $this->countChannels = count($this->channels);
    }

    /**
     * @inheritDoc
     */
    public function getChannels(): array
    {
        return $this->channels;
    }

    /**
     * @inheritDoc
     */
    public function getMethodChannels() : array
    {
        return $this->methodChannels;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->countChannels;
    }

    /**
     * Sets channels
     *
     * @param array $channels
     *
     * @throws InvalidArgumentException
     */
    private function setChannels(array $channels)
    {
        if (empty($channels)) {
            $this->channels = self::$defaultChannels;
            return;
        }

        if (!empty(array_diff($channels, self::$defaultChannels))) {
            throw new InvalidArgumentException(
                sprintf('Invalid channel list [%s]. Please choose ones form the [%s].',
                    implode(', ' , $channels),
                    implode(', ' , self::$defaultChannels)
                )
            );
        }

        $this->channels = $channels;
    }

    /**
     * Sets method channels
     *
     * @param array $channels
     */
    private function setMethodChannels(array $channels)
    {
        $this->methodChannels = array_map(function($item) {
            return 'get' . ucwords($item);
        }, $channels);
    }
}
