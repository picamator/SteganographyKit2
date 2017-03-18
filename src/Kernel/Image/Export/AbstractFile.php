<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\File\Api\NameGeneratorInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ExportInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;

/**
 * Export image to file string
 *
 * It implements template pattern
 */
abstract class AbstractFile implements ExportInterface
{
    /**
     * @var ImageInterface
     */
    private $image;

    /**
     * @var NameGeneratorInterface
     */
    private $nameGenerator;

    /**
     * @var string
     */
    private $savePath;

    /**
     * @param ImageInterface $image
     * @param NameGeneratorInterface $nameGenerator
     * @param $savePath
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        ImageInterface $image,
        NameGeneratorInterface $nameGenerator,
        string $savePath
    ) {
        $this->image = $image;
        $this->nameGenerator = $nameGenerator;

        $this->setSavePath($savePath);
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    final public function export(): string
    {
        $resourcePath = $this->image->getResource()->getPath();
        $path = rtrim($this->savePath, '/\\') . DIRECTORY_SEPARATOR . $this->nameGenerator->generate($resourcePath);

        $result = $this->saveImage($this->image->getResource(), $path);
        if ($result === false) {
            throw new RuntimeException(
                sprintf('Failed to save image "%s" to the destination "%s"', $resourcePath, $path)
            );
        }

        return $path;
    }

    /**
     * Validate savePath
     *
     * @param string $savePath
     * 
     * @throws InvalidArgumentException
     *
     * @codeCoverageIgnore
     */
    private function setSavePath($savePath)
    {
        $dirPath = dirname($savePath);
        if(!file_exists($dirPath) && !mkdir($dirPath, 0755, true)) {
            throw new InvalidArgumentException(
                sprintf('Impossible create sub-folders structure for destination "%s"', $savePath)
            );
        }

        if(!is_writable($dirPath)) {
            throw new InvalidArgumentException(
                sprintf('Destination does not have writable permission "%s"', $dirPath)
            );
        }
        
        $this->savePath = $savePath;
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
