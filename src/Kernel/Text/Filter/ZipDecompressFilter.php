<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface;

/**
 * Decompress text using Zip
 *
 * @package Kernel\Text\Filter
 */
final class ZipDecompressFilter implements FilterInterface
{
    /**
     * @inheritDoc
     */
    public function filter(string $text): string
    {
        $result = gzuncompress($text);
        // @codeCoverageIgnoreStart
        if ($result === false) {
            throw new RuntimeException(
                sprintf('Failed decompressing string "%s"', $text)
            );
        }
        // @codeCoverageIgnoreEnd

        return $result;
    }
}
