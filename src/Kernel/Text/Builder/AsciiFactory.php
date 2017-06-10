<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Builder;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Text\Api\Data\AsciiInterface;
use Picamator\SteganographyKit2\Kernel\Text\Data\Ascii;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create ascii value object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * * Validate ``char``
 * * Create ``Ascii``
 *
 * State
 * -----
 * * Ascii code container
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor argument.
 *
 * Check list
 * ----------
 * * Single responsibility ``-``
 * * Tell don't ask ``+``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
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
     * @inheritDoc
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
