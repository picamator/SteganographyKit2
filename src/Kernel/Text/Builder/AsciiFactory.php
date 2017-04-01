<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Builder;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\ByteFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\Builder\AsciiFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\Data\AsciiInterface;
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
final class AsciiFactory implements AsciiFactoryInterface
{
    /**
     * @var array
     */
    private $asciiContainer = [];

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ByteFactoryInterface
     */
    private $byteFactory;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ByteFactoryInterface $byteFactory
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ByteFactoryInterface $byteFactory,
        $className = 'Picamator\SteganographyKit2\Kernel\Text\Data\Ascii'
    ) {
        $this->objectManager = $objectManager;
        $this->byteFactory = $byteFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(string $char): AsciiInterface
    {
        if (isset($this->asciiContainer[$char])) {
            return $this->asciiContainer[$char];
        }

        if (strlen($char) !== 1) {
            throw new InvalidArgumentException(
                sprintf('Invalid character "%s" length. It supports single char only.', $char)
            );
        }

        $charCode = decbin(ord($char));
        $byte = $this->byteFactory->create($charCode);

        $this->asciiContainer[$char] = $this->objectManager->create($this->className, [$byte, $char]);

        return $this->asciiContainer[$char];
    }
}
