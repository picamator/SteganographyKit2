<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\Data;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;

/**
 * Info value object
 *
 * It's not need to check options item data type because Size object is creating by Factory.
 * Factory takes responsibility for options data typing. It makes creating data object faster.
 *
 * Use composition to extend value object. Don't run ``__construct`` directly to modify object.
 * Protection to run ``__construct`` twice was not added for performance reason supposing the client code has height level of trust.
 *
 * @package Kernel\File
 *
 * @codeCoverageIgnore
 */
final class Info implements InfoInterface
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
     * @var int
     */
    private $type;

    /**
     * @var int
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
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $path;

    /**
     * @param SizeInterface $size
     * @param array $options
     */
    public function __construct(SizeInterface $size, array $options)
    {
        $this->size = $size;
        $this->attr = $options['attr'];
        $this->type = $options['type'];
        $this->bits = $options['bits'];
        $this->channels = $options['channels'];
        $this->mime = $options['mime'];
        $this->name = $options['name'];
        $this->path = $options['path'];
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
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function getBits(): int
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

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
