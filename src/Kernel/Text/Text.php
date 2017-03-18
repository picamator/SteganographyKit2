<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text;

use Picamator\SteganographyKit2\Kernel\Text\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\LengthFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\TextInterface;

/**
 * Text
 */
class Text implements TextInterface
{
    /**
     * @var IteratorFactoryInterface
     */
    private $iteratorFactory;

    /**
     * @var LengthFactoryInterface
     */
    private $lengthFactory;

    /**
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $countBit;

    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @param IteratorFactoryInterface $iteratorFactory
     * @param LengthFactoryInterface $lengthFactory
     * @param string $text
     */
    public function __construct(
        IteratorFactoryInterface $iteratorFactory,
        LengthFactoryInterface $lengthFactory,
        string $text
    ) {
        $this->iteratorFactory = $iteratorFactory;
        $this->lengthFactory = $lengthFactory;
        $this->text = $text;
    }

    /**
     * @inheritDoc
     */
    public function getCountBit(): int
    {
        if (is_null($this->countBit)) {
            $this->countBit = $this->lengthFactory->create($this->text)->getCountBit();
        }

        return $this->countBit;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        if (is_null($this->iterator)) {
            $this->iterator = $this->iteratorFactory->create($this);
        }

        return $this->iterator;
    }
}
