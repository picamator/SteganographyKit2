<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Primitive\Data;

use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;

/**
 * Byte value object
 *
 * @codeCoverageIgnore
 */
class Byte implements ByteInterface
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
