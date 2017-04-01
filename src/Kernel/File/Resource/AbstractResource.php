<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\Resource;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;

/**
 * Resource image implementation for different image types
 *
 * It's part of Bridge pattern between Abstraction ``Image`` and ``Resource`` implementation.
 * It helps to extend application with different image type.
 *
 * It implements template pattern.
 *
 * Class type
 * ----------
 * Non-sharable service. The ``Resource`` depends on users data - image ``$path``.
 *
 * Responsibility
 * --------------
 * Generate file name based on ``$sourceName``
 *
 * State
 * -----
 * * Resource
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as method argument.
 *
 * @package Kernel\File\Resource
 */
abstract class AbstractResource implements ResourceInterface
{
    /**
     * @var resource
     */
    private $resource;

    /**
     * @var InfoInterface
     */
    private $info;

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
    final public function getInfo(): InfoInterface
    {
        return $this->info;
    }

    /**
     * @inheritDoc
     */
    final public function getResource()
    {
        if (!is_null($this->resource)) {
            return $this->resource;
        }

        $path = $this->info->getPath();
        $resource = $this->getImage($path);
        if ($resource === false) {
            throw new RuntimeException(
                sprintf('Cannot create image for path "%s"', $path)
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
