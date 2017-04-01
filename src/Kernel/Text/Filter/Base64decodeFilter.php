<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface;

/**
 * Decode text using base64encode
 *
 * @package Kernel\Text\Filter
 */
final class Base64decodeFilter implements FilterInterface
{
    /**
     * @inheritDoc
     */
    public function filter(string $text): string
    {
        $result = base64_decode($text);
        // @codeCoverageIgnoreStart
        if ($result === false) {
            throw new RuntimeException(
                sprintf('Failed base64decoding string "%s"', $text)
            );
        }
        // @codeCoverageIgnoreEnd

        return $result;
    }
}
