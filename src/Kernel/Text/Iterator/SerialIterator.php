<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Iterator;

use Picamator\SteganographyKit2\Kernel\Text\Api\Iterator\SerialIteratorInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\TextInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\AsciiFactoryInterface;

/**
 * Serial iterator
 *
 * Iterate char bits by bits from the beginning to the end
 */
class SerialIterator implements SerialIteratorInterface
{
    /**
     * @var TextInterface
     */
    private $text;

    /**
     * @var AsciiFactoryInterface
     */
    private $asciiFactory;

    /**
     * @var int
     */
    private $lengthBits;

    /**
     * Current index
     *
     * @var int
     */
    private $index = 0;

    /**
     * @var array
     */
    private $currentContainer;

    /**
     * @param TextInterface $text
     * @param AsciiFactoryInterface $asciiFactory
     */
    public function __construct(
        TextInterface $text,
        AsciiFactoryInterface $asciiFactory
    ) {
        $this->text = $text;
        $this->asciiFactory = $asciiFactory;

        $this->lengthBits = $this->text->getLengthBits();
    }

    /**
     * @inheritDoc
     *
     * @return string "0" or "1"
     */
    public function current()
    {
        if (empty($this->currentContainer)) {
            $charIndex = $this->index % 8;
            $char = substr($this->text->getText(), $charIndex, 1);
            $currentByte = $this->asciiFactory->create($char)
                ->getByte();

            $this->currentContainer = str_split($currentByte->getBinary());
        }

        return array_shift($this->currentContainer);
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->index ++;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return $this->index < $this->lengthBits;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->index = 0;
    }
}
