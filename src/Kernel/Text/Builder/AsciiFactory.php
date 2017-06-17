<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Builder;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Text\Api\Data\AsciiInterface;
use Picamator\SteganographyKit2\Kernel\Text\Data\Ascii;

/**
 * Create ascii value object
 *
 * @package Kernel\Text
 */
final class AsciiFactory
{
    /**
     * @var array
     */
    private static $asciiContainer = [];

    /**
     * @param string $char
     *
     * @throws InvalidArgumentException
     *
     * @return AsciiInterface
     */
    public static function create(string $char): AsciiInterface
    {
        if (isset(self::$asciiContainer[$char])) {
            return self::$asciiContainer[$char];
        }

        if (strlen($char) !== 1) {
            throw new InvalidArgumentException(
                sprintf('Invalid character "%s" length. It supports single char only.', $char)
            );
        }

        $charCode = decbin(ord($char));
        $byte = ByteFactory::create($charCode);

        self::$asciiContainer[$char] = new Ascii($byte, $char);

        return self::$asciiContainer[$char];
    }
}
