<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Text\Filter;

use Picamator\SteganographyKit2\Exception\RuntimeException;
use Picamator\SteganographyKit2\Text\Api\FilterInterface;

/**
 * Decode text using base64encode
 */
class Base64decodeFilter implements FilterInterface
{
    /**
     * @inheritDoc
     */
    public function filter(string $text): string
    {
        $result = base64_decode($text);
        if ($result === false) {
            throw new RuntimeException(
                sprintf('Failed base64decoding string "%s"', $text)
            );
        }

        return $result;
    }
}
