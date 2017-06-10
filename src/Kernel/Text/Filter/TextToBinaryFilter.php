<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface;
use Picamator\SteganographyKit2\Kernel\Text\Builder\AsciiFactory;

/**
 * Covert ascii text to binary string
 *
 * @package Kernel\Text\Filter
 */
final class TextToBinaryFilter implements FilterInterface
{
    /**
     * @inheritDoc
     */
    public function filter(string $text): string
    {
        $textLength = strlen($text);

        $i = 0;
        $result = '';
        while ($i < $textLength) {
            $charByte = substr($text, $i, 1);
            $ascii = AsciiFactory::create($charByte);

            $result .= $ascii->getByte()->getBinary();

            $i ++;
        }

        return $result;
    }
}
