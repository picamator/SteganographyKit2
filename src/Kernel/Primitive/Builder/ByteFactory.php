<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Primitive\Builder;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Data\Byte;

/**
 * Create Byte object
 *
 * @package Kernel\Primitive
 *
 * @codeCoverageIgnore
 */
final class ByteFactory
{
    /**
     * @inheritDoc
     */
    public static function create(string $byte) : ByteInterface
    {
        return new Byte($byte);
    }
}
