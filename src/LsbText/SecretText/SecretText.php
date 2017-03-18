<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\LsbText\SecretText;

use Picamator\SteganographyKit2\Kernel\SecretText\Api\EndMarkInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\TextInterface;

/**
 * SecretText is an information for hide or protection signature
 */
class SecretText implements SecretTextInterface
{
    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @var EndMarkInterface
     */
    private $endMark;

    /**
     * @var TextInterface
     */
    private $text;

    /**
     * @param TextInterface $text
     * @param EndMarkInterface $endMark
     */
    public function __construct(TextInterface $text, EndMarkInterface $endMark)
    {
        $this->text = $text;
        $this->endMark = $endMark;
    }

    /**
     * @inheritDoc
     */
    public function getResource()
    {
        return $this->text->getText();
    }

    /**
     * @inheritDoc
     */
    public function getCountBit(): int
    {
        return $this->text->getCountBit();
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        if (is_null($this->iterator)) {
            $this->iterator = new \AppendIterator();
            $this->iterator->append($this->text->getIterator());
            $this->iterator->append($this->endMark->getIterator());
        }

        return $this->iterator;
    }
}
