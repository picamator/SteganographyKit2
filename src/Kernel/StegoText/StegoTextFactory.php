<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\StegoText;

use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextFactoryInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextInterface;

/**
 * Create StegoText object
 *
 * @package Kernel\StegoText
 *
 * @codeCoverageIgnore
 */
final class StegoTextFactory implements StegoTextFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(ImageInterface $image) : StegoTextInterface
    {
        return new StegoText($image);
    }
}
