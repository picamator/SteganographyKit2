<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Resource;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;

/**
 * Resource Palette image
 *
 * @package Kernel\Image\Resource
 */
class PaletteResource implements ResourceInterface
{
    /**
     * @var SizeInterface
     */
    private $size;

    /**
     * @var string
     */
    private $name;

    /**
     * @var resource
     */
    private $resource;

    /**
     * @param SizeInterface $size
     * @param string $name
     */
    public function __construct(
        SizeInterface $size,
        string $name
    ) {
        $this->size = $size;
        $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getSize(): SizeInterface
    {
        return $this->size;
    }

    /**
     * @inheritDoc
     */
    public function getResource()
    {
        if (!is_null($this->resource)) {
            return $this->resource;
        }

        $this->resource = imagecreatetruecolor($this->size->getWidth(), $this->size->getHeight());

        // @codeCoverageIgnoreStart
        if ($this->resource === false) {
            throw new RuntimeException(
                sprintf('Cannot create image with width "%s", height "%s"', $this->size->getWidth(),  $this->size->getHeight())
            );
        }
        // @codeCoverageIgnoreEnd

        return $this->resource;
    }
}
