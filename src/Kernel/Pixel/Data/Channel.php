<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Pixel\Data;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface;

/**
 * Color channel value object
 *
 * Use composition to extend value object. Don't run ``__construct`` directly to modify object.
 * Protection to run ``__construct`` twice was not added for performance reason supposing the client code has height level of trust.
 *
 * @package Kernel\Pixel
 *
 * @codeCoverageIgnore
 */
final class Channel implements ChannelInterface
{
    /**
     * @var array
     */
    private $channelList;

    /**
     * @var array
     */
    private $methodList;

    /**
     * @var int
     */
    private $countChannel;

    /**
     * Make object ready before asking method helps to increase performance
     * Currently channel is using for each Pixel iterator, therefore all getters mast be as simple as possible
     *
     * @param array $channelList The channels order in array important for encode as well as for decode
     */
    public function __construct(array $channelList)
    {
        $this->channelList = $channelList;

        $this->setMethodList($channelList);
        $this->setCountChannel($channelList);
    }

    /**
     * @inheritDoc
     */
    public function getChannelList(): array
    {
        return $this->channelList;
    }

    /**
     * @inheritDoc
     */
    public function getChannel(int $index): string
    {
        if (!isset($index, $this->channelList)) {
            throw new InvalidArgumentException(
                sprintf('Invalid index "%s". Choose one from the list "%s".', $index, implode(', ', array_keys($this->channelList)))
            );
        }

        return $this->channelList[$index];
    }

    /**
     * @inheritDoc
     */
    public function getMethodList() : array
    {
        return $this->methodList;
    }

    /**
     * @inheritDoc
     */
    public function getMethod(int $index): string
    {
        if (!isset($index, $this->methodList)) {
            throw new InvalidArgumentException(
                sprintf('Invalid index "%s". Choose one from the list "%s".', $index, implode(', ', array_keys($this->methodList)))
            );
        }

        return $this->methodList[$index];
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->countChannel;
    }

    /**
     * Sets method channels
     *
     * @param array $channelList
     */
    private function setMethodList(array $channelList)
    {
        $this->methodList = array_map(function($item) {
            return 'get' . ucwords($item);
        }, $channelList);
    }

    /**
     * Sets count channels
     *
     * @param array $channelList
     */
    private function setCountChannel(array $channelList)
    {
        $this->countChannel = count($channelList);
    }
}
