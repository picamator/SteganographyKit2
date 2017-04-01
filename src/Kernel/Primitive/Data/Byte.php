<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Primitive\Data;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;

/**
 * Byte value object
 *
 * Use composition to extend value object. Don't run ``__construct`` directly to modify object.
 * Protection to run ``__construct`` twice was not added for performance reason supposing the client code has height level of trust.
 *
 * @package Kernel\Primitive
 *
 * @codeCoverageIgnore
 */
final class Byte implements ByteInterface
{
    /**
     * @var string
     */
    private $byte;

    /**
     * @var string
     */
    private $binaryByte;

    /**
     * @var int
     */
    private $intByte;

    /**
     * @param string $byte
     */
    public function __construct(string $byte)
    {
        $this->byte = $byte;
    }

    /**
     * @inheritDoc
     */
    public function getBinary() : string
    {
        if (is_null($this->binaryByte)) {
            $this->binaryByte = sprintf('%08d',  $this->byte);
        }

        return $this->binaryByte;
    }

    /**
     * @inheritDoc
     */
    public function getInt() : int
    {
        if (is_null($this->intByte)) {
            $this->intByte = bindec($this->byte);
        }

        return $this->intByte;
    }
}
