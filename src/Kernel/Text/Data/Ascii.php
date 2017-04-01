<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Data;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\Data\AsciiInterface;

/**
 * Ascii value object
 *
 * @package Kernel\Text
 *
 * @codeCoverageIgnore
 */
final class Ascii implements AsciiInterface
{
    /**
     * @var ByteInterface
     */
    private $byte;

    /**
     * @var string
     */
    private $char;

    /**
     * @param ByteInterface $byte
     * @param string $char
     */
    public function __construct(ByteInterface $byte, string $char)
    {
        $this->byte = $byte;
        $this->char = $char;
    }

    /**
     * @inheritDoc
     */
    public function getChar(): string
    {
        return $this->char;
    }

    /**
     * @inheritDoc
     */
    public function getByte(): ByteInterface
    {
        return $this->byte;
    }
}
