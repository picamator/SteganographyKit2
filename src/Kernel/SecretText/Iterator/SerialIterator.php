<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\SecretText\Iterator;

use Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorInterface;

/**
 * Serial bitwise iterator
 *
 * Iterate binary string bit by bit
 *
 * Class type
 * ----------
 * Non-sharable
 *
 * Responsibility
 * --------------
 * Iterate over binary string
 *
 * State
 * -----
 * * Iteration state: current, key, etc.
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Cannot be injected in any class. Iterator owns only by ``SecretText``.
 *
 * @package Kernel\SecretText\Iterator
 */
final class SerialIterator implements IteratorInterface
{
    /**
     * @var string
     */
    private $binaryText;

    /**
     * @var int
     */
    private $maxIndex;

    /**
     * @var int
     */
    private $index = 0;

    /**
     * @param string $binaryText
     */
    public function __construct(string $binaryText)
    {
        $this->binaryText = $binaryText;
        $this->maxIndex = strlen($binaryText);
    }

    /**
     * @inheritDoc
     *
     * @return string '0' or '1'
     */
    public function current()
    {
        return substr($this->binaryText, $this->index, 1);
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
        return $this->index < $this->maxIndex;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->index = 0;
    }
}
