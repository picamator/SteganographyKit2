<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\NameGenerator;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\File\Api\NameGeneratorInterface;

/**
 * Strategy to generate file name
 *
 * It keeps identical to source name
 *
 * *Attention*: save destination should be different to prevent source override
 */
class SourceIdentical implements NameGeneratorInterface
{
    /**
     * @inheritDoc
     */
    public function generate(string $path) : string
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException(
                sprintf('Invalid path "%s"', $path)
            );
        }

        return pathinfo($path, PATHINFO_BASENAME);
    }
}
