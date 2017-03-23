<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Data;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface;

/**
 * Color channel value object
 */
class Channel implements ChannelInterface
{
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
     */
    public function __construct(array $channels = [])
    {
        $this->channels = $channels;
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
