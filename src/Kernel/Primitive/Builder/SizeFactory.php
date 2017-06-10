<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Primitive\Builder;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Data\Size;

/**
 * Create Size object
 *
 * @package Kernel\Image
 *
 * @codeCoverageIgnore
 */
final class SizeFactory
{
    /**
     * @inheritDoc
     */
    public static function create(int $width, int $height) : SizeInterface
    {
        return new Size($width, $height);
    }
}
