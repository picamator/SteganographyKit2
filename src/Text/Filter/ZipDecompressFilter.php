<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Text\Filter;

use Picamator\SteganographyKit2\Exception\RuntimeException;
use Picamator\SteganographyKit2\Text\Api\FilterInterface;

/**
 * Decompress text using Zip
 */
class ZipDecompressFilter implements FilterInterface
{
    /**
     * @inheritDoc
     */
    public function filter(string $text): string
    {
        $result = gzuncompress($text);
        if ($result === false) {
            throw new RuntimeException(
                sprintf('Failed decompressing string "%s"', $text)
            );
        }

        return $result;
    }
}
