<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\SecretText;

use Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\TextInterface;

/**
 * SecretText is an information for hide or protection signature
 *
 * Class type
 * ----------
 * Non-sharable service.
 *
 * Responsibility
 * --------------
 * Iterate over binary text with ``EndMark``. It's explicitly used binary texts instead of recursive iteration over abstraction.
 * The reason here it's recursion iteration has sense only for ``Image`` as a ``SecretText`` but don't have for ``Text``.
 * Therefore the most abstract ``SecretText`` is a binary string.
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
 * Only as a method argument, because ``SecretText`` depends from user data - ``text``.
 *
 * Check list
 * ----------
 * * Single responsibility ``+``
 * * Tell don't ask ``+``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
 *
 * @package Kernel\SecretText
 */
final class SecretText implements SecretTextInterface
{
    /**
     * @var InfoMarkInterface
     */
    private $infoMark;

    /**
     * @var IteratorFactoryInterface
     */
    private $iteratorFactory;

    /**
     * @var string
     */
    private $binaryText;

    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @param InfoMarkInterface $infoMark
     * @param IteratorFactoryInterface $iteratorFactory
     * @param string
     */
    public function __construct(
        InfoMarkInterface $infoMark,
        IteratorFactoryInterface $iteratorFactory,
        string $binaryText
    ) {
        $this->infoMark = $infoMark;
        $this->iteratorFactory = $iteratorFactory;
        $this->binaryText = $binaryText;
    }

    /**
     * Cloning object with iterator might be tricky,
     * Especially when iterator instance are internally caching
     */
    final private function __clone()
    {
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getBinaryText()
    {
        return $this->binaryText;
    }

    /**
     * @inheritDoc
     */
    public function getInfoMark(): InfoMarkInterface
    {
        return $this->infoMark;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        if (is_null($this->iterator)) {
            $this->iterator = new \AppendIterator();
            $this->iterator->append($this->infoMark->getIterator());
            $this->iterator->append($this->iteratorFactory->create($this->binaryText));
        }

        return $this->iterator;
    }
}
