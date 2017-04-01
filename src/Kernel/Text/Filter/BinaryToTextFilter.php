<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface;

/**
 * Covert binary string to a ascii text
 *
 * @package Kernel\Text\Filter
 */
final class BinaryToTextFilter implements FilterInterface
{
    /**
     * @var array
     */
    private $charContainer = [];

    /**
     * @inheritDoc
     */
    public function filter(string $text): string
    {
        $textLength = strlen($text);

        $i = 0;
        $result = '';
        while ($i < $textLength) {
            $charByte = substr($text, $i, 8);
            $result .= $this->getChar($charByte);

            $i += 8;
        }

        return $result;
    }

    /**
     * Gets char
     *
     * @param string $charByte
     *
     * @return string
     */
    private function getChar(string $charByte) : string
    {
        if (!isset($this->charContainer[$charByte])) {
            $charCode = bindec($charByte);
            $this->charContainer[$charByte] = chr($charCode);
        }

        return $this->charContainer[$charByte];
    }
}
