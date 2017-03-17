<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface;

/**
 * Encode text using base64encode
 */
class Base64encodeFilter implements FilterInterface
{
    /**
     * @inheritDoc
     */
    public function filter(string $text): string
    {
        $result = base64_encode($text);
        // @codeCoverageIgnoreStart
        if ($result === false) {
            throw new RuntimeException(
                sprintf('Failed base64encoding string "%s"', $text)
            );
        }
        // @codeCoverageIgnoreEnd

        return $result;
    }
}
