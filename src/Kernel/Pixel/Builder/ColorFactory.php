<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Pixel\Builder;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Data\Color;
use Picamator\SteganographyKit2\Kernel\Pixel\Data\NullColor;

/**
 * Create Color object
 *
 * @package Kernel\Pixel
 *
 * @codeCoverageIgnore
 */
final class ColorFactory
{
    /**
     * @inheritDoc
     */
    public static function create(array $data) : ColorInterface
    {
        $red = $data['red'] ?? new NullColor();
        $green = $data['green'] ??  new NullColor();
        $blue = $data['blue'] ??  new NullColor();
        $alpha = $data['alpha'] ??  new NullColor();

        return new Color($red, $green, $blue, $alpha);
    }
}
