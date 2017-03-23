<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Data;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;

/**
 * Info value object
 *
 * It's not need to check the options item data type as Size object are creating by Factory.
 * The Factory get's responsibility for options data typing. This case make creating data object faster.
 *
 * @codeCoverageIgnore
 */
class Info implements InfoInterface
{
    /**
     * @var SizeInterface
     */
    private $size;

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
    private $countChannels;

    /**
     * @var string
     */
    private $mime;

    /**
     * @var array
     */
    private $extraInfo;

    /**
     * @var array
     */
    private $iptc;

    /**
     * @param SizeInterface $size
     * @param array $options
     */
    public function __construct(SizeInterface $size, array $options)
    {
        $this->size = $size;
        $this->attr = $options['attr'] ?? '';
        $this->bits = $options['bits'] ?? 0;
        $this->countChannels = $options['countChannels'] ?? 0;
        $this->mime = $options['mime'] ?? '';
        $this->extraInfo = $options['extraInfo'] ?? '';
        $this->iptc = $options['iptc'] ?? '';
    }

    /**
     * @inheritDoc
     */
    public function getSize(): SizeInterface
    {
        return $this->size;
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
    public function getCountChannels(): int
    {
        return $this->countChannels;
    }

    /**
     * @inheritDoc
     */
    public function getMime(): string
    {
        return $this->mime;
    }

    /**
     * @inheritDoc
     */
    public function getIptc(): array
    {
        return $this->iptc;
    }

    /**
     * @inheritDoc
     */
    public function getExtraInfo(): array
    {
        return $this->extraInfo;
    }
}
