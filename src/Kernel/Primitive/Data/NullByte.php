<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Primitive\Data;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;

/**
 * Null byte value object
 *
 * @package Kernel\Primitive
 *
 * @codeCoverageIgnore
 */
class NullByte implements ByteInterface
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
}
