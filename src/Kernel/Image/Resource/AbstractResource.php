<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Resource;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\SizeFactoryInterface;

/**
 * Resource image implementation for different image types
 *
 * It's part of Bridge pattern between Abstraction "Image" and "Resource" implementation
 * It helps to extend application with different image type
 *
 * It implements template pattern
 */
abstract class AbstractResource implements ResourceInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var resource
     */
    private $resource;

    /**
     * @var SizeInterface
     */
    private $size;

    /**
     * @var string
     */
    private $name;

    /**
     * @param SizeInterface $size
     * @param string $path
     */
    public function __construct(SizeInterface $size, string $path)
    {
        $this->size = $size;
        $this->path = $path;
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
    final public function getName(): string
    {
        if (is_null($this->name)) {
            $this->name = pathinfo($this->path, PATHINFO_BASENAME);
        }

        return $this->name;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    final public function getSize(): SizeInterface
    {
        return $this->size;
    }

    /**
     * @inheritDoc
     */
    final public function getResource()
    {
        if (!is_null($this->resource)) {
            return $this->resource;
        }

        $resource = $this->getImage($this->path);
        if ($resource === false) {
            throw new RuntimeException(
                sprintf('Cannot create image for path "%s"', $this->path)
            );
        }

        return $this->resource = $resource;
    }

    /**
     * Gets Image
     *
     * @param string $path
     *
     * @return resource | bool resource if ok or false otherwise
     */
    abstract protected function getImage(string $path);
}
