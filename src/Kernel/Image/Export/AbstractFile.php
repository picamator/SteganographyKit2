<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\File\Api\Data\WritablePathInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\NameGeneratorInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ExportInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;

/**
 * Export image to file string
 *
 * It implements template pattern.
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Export ``Resource`` to file.
 *
 * State
 * -----
 * No state
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor argument.
 *
 * @package Kernel\Image\Export
 */
abstract class AbstractFile implements ExportInterface
{
    /**
     * @var WritablePathInterface
     */
    private $path;

    /**
     * @var NameGeneratorInterface
     */
    private $nameGenerator;

    /**
     * @param WritablePathInterface $path
     * @param NameGeneratorInterface $nameGenerator
     */
    public function __construct(
        WritablePathInterface $path,
        NameGeneratorInterface $nameGenerator
    ) {
        $this->path = $path;
        $this->nameGenerator = $nameGenerator;
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    final public function export(ResourceInterface $resource): string
    {
        $resourceName = $resource->getName();
        $savePath = rtrim($this->path->getPath(), '/\\') . DIRECTORY_SEPARATOR . $this->nameGenerator->generate($resourceName);

        $result = $this->saveImage($resource, $savePath);
        if ($result === false) {
            throw new RuntimeException(
                sprintf('Failed to save image "%s" to the destination "%s"', $resourceName, $savePath)
            );
        }

        return $savePath;
    }

    /**
     * Save image
     *
     * @param ResourceInterface $resource
     * @param string $path
     *
     * @return bool
     */
    abstract protected function saveImage(ResourceInterface $resource, string $path) : bool;
}
