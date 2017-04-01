<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Kernel\Text\Api\Builder\AsciiFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface;

/**
 * Covert ascii text to binary string
 *
 * @package Kernel\Text\Filter
 */
final class TextToBinaryFilter implements FilterInterface
{
    /**
     * @var AsciiFactoryInterface
     */
    private $asciiFactory;

    /**
     * @param AsciiFactoryInterface $asciiFactory
     */
    public function __construct(AsciiFactoryInterface $asciiFactory)
    {
        $this->asciiFactory = $asciiFactory;
    }

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
            $ascii = $this->asciiFactory->create($charByte);

            $result .= $ascii->getByte()->getBinary();

            $i ++;
        }

        return $result;
    }
}
