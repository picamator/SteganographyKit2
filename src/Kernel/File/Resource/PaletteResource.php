<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\Resource;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;

/**
 * Resource Palette image
 *
 * @package Kernel\File\Resource
 */
final class PaletteResource implements ResourceInterface
{
    /**
     * @var InfoInterface
     */
    private $info;

    /**
     * @var resource
     */
    private $resource;

    /**
     * @param InfoInterface $info
     */
    public function __construct(InfoInterface $info)
    {
        $this->info = $info;
    }

    /**
     * Free resource
     *
     * @codeCoverageIgnore
     */
    public function __destruct()
    {
        if (is_resource($this->resource)) {
            imagedestroy($this->resource);
        }
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getInfo(): InfoInterface
    {
        return $this->info;
    }

    /**
     * @inheritDoc
     */
    public function getResource()
    {
        if (!is_null($this->resource)) {
            return $this->resource;
        }

        $size = $this->info->getSize();
        $this->resource = imagecreatetruecolor($size->getWidth(), $size->getHeight());

        // @codeCoverageIgnoreStart
        if ($this->resource === false) {
            throw new RuntimeException(
                sprintf('Cannot create image with width "%s", height "%s"', $size->getWidth(),  $size->getHeight())
            );
        }
        // @codeCoverageIgnoreEnd

        return $this->resource;
    }
}
