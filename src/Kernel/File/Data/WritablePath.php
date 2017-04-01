<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\Data;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\WritablePathInterface;

/**
 * Writable path value object
 *
 * Use composition to extend value object. Don't run ``__construct`` directly to modify object.
 * Protection to run ``__construct`` twice was not added for performance reason supposing the client code has height level of trust.
 *
 * @package Kernel\File
 *
 * @codeCoverageIgnore
 */
final class WritablePath implements WritablePathInterface
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
