<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\Data;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\WritablePathInterface;

/**
 * Writable path value object
 */
class WritablePath implements WritablePathInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
