<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Data;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;

/**
 * Size value object
 *
 * It's not need to check the options item data type as Size object are creating by Factory.
 * The Factory get's responsibility for options data typing. This case make creating data object faster.
 *
 * @codeCoverageIgnore
 */
class Size implements SizeInterface
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var string
     */
    private $attr;

    /**
     * @var string
     */
    private $bits;

    /**
     * @var int
     */
    private $channels;

    /**
     * @var string
     */
    private $mime;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->width = $options['width'] ?? 0;
        $this->height = $options['height'] ?? 0;
        $this->attr = $options['attr'] ?? '';
        $this->bits = $options['bits'] ?? 0;
        $this->channels = $options['channels'] ?? 0;
        $this->mime = $options['mime']?? '';
    }

    /**
     * @inheritDoc
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @inheritDoc
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @inheritDoc
     */
    public function getAttr(): string
    {
        return $this->attr;
    }

    /**
     * @inheritDoc
     */
    public function getBits(): string
    {
        return $this->bits;
    }

    /**
     * @inheritDoc
     */
    public function getChannels(): int
    {
        return $this->channels;
    }

    /**
     * @inheritDoc
     */
    public function getMime(): string
    {
        return $this->mime;
    }
}
