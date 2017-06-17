<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\Resource;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceFactoryInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;

/**
 * Create Resource object
 *
 * @package Kernel\File\Resource
 *
 * @codeCoverageIgnore
 */
final class ResourceFactory implements ResourceFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createJpegResource(InfoInterface $info): ResourceInterface
    {
        return new JpegResource($info);
    }

    /**
     * @inheritDoc
     */
    public function createPngResource(InfoInterface $info): ResourceInterface
    {
        return new PngResource($info);
    }

    /**
     * @inheritDoc
     */
    public function createPaletteResource(InfoInterface $info): ResourceInterface
    {
        return new PaletteResource($info);
    }
}
