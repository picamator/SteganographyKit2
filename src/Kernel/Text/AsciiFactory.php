<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\ByteFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\AsciiFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\Data\AsciiInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create ascii value object
 */
class AsciiFactory implements AsciiFactoryInterface
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
        if (array_key_exists($char, $this->asciiContainer)) {
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
