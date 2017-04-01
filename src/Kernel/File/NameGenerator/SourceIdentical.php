<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\NameGenerator;

/**
 * Strategy to generate file name
 *
 * It keeps identical to source name.
 *
 * *Attention*: save destination should be different to prevent source override
 *
 * Class type
 * ----------
 * Sharable service strategy. It's helper class as a namespace over ``generate`` function.
 *
 * Responsibility
 * --------------
 * Generate file name based on ``$sourceName``
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as constructor argument.
 *
 * @package Kernel\File
 *
 * @codeCoverageIgnore
 */
final class SourceIdentical extends AbstractGenerator
{
    /**
     * @inheritDoc
     */
    public function getFileName(string $sourceName) : string
    {
        return $sourceName;
    }
}
