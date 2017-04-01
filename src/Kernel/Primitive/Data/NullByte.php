<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Primitive\Data;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;

/**
 * Null byte value object
 *
 * Use composition to extend value object. Don't run ``__construct`` directly to modify object.
 * Protection to run ``__construct`` twice was not added for performance reason supposing the client code has height level of trust.
 *
 * @package Kernel\Primitive
 *
 * @codeCoverageIgnore
 */
final class NullByte implements ByteInterface
{
    /**
     * @var string
     */
    private $binaryByte;

    /**
     * @var int
     */
    private $intByte;

    public function __construct()
    {
        $this->binaryByte = '00000000';
        $this->intByte = 0;
    }

    /**
     * @inheritDoc
     */
    public function getBinary() : string
    {
        return $this->binaryByte;
    }

    /**
     * @inheritDoc
     */
    public function getInt() : int
    {
        return $this->intByte;
    }

    public function __toString()
    {
        return $this->getBinary();
    }
}
