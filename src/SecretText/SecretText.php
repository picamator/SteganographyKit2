<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\SecretText\Data;

use Picamator\SteganographyKit2\SecretText\Api\EndMarkInterface;
use Picamator\SteganographyKit2\SecretText\Api\SecretTextInterface;

/**
 * SecretText is an information for hide or protection signature
 */
class SecretText implements SecretTextInterface
{
    /**
     * @var \Iterator
     */
    private $secretIterator;

    /**
     * @var EndMarkInterface
     */
    private $endMark;

    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @param \Iterator $secretIterator
     * @param EndMarkInterface $endMark
     */
    public function __construct(\Iterator $secretIterator, EndMarkInterface $endMark)
    {
        $this->secretIterator = $secretIterator;
        $this->endMark = $endMark;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        if (is_null($this->iterator)) {
            $this->iterator = new \AppendIterator();
            $this->iterator->append($this->iterator);
            $this->iterator->append($this->endMark->getIterator());
        }

        return $this->iterator;
    }
}
