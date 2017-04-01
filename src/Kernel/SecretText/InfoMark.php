<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\SecretText;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface;

/**
 * Information marker contains technical details such as size
 *
 * Size information helps:
 * * increase decoding performance by stopping process at the secret text end
 * * convert secret text from binary string to ``Text`` or ``Image``
 *
 * *Attention*: Calculation iteration item numbers includes hardcoded channel number for ``Image`` case.
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * * Iterate over Information
 * * Count iteration elements
 *
 * State
 * -----
 * * Number of iteration elements
 * * Iterator
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
 * @package Kernel\SecretText
 */
class InfoMark implements InfoMarkInterface
{
    /**
     * @var SizeInterface
     */
    private $size;

    /**
     * @var string
     */
    private $binary;

    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @var int
     */
    private $secretTextCount;

    /**
     * @param SizeInterface $size
     *
     * @throws InvalidArgumentException
     */
    public function __construct(SizeInterface $size)
    {
        $this->size = $size;
        $this->setBinary($size);
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
    public function getSize(): SizeInterface
    {
        return $this->size;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getBinary(): string
    {
        return $this->binary;
    }

    /**
     * @inheritDoc
     */
    public function countText(): int
    {
        if (is_null($this->secretTextCount)) {
            // 8 - number of bits
            // 3 - number of channels
            // height = 0 means that it's a 1-D secret text in other words it's a ``Text``
            // height <> 0 means it's a 2-D secret text in other words it's an ``Image``
            $height = $this->size->getHeight();
            $height = $height === 0 ? 8 : $height * 3 * 8;

            $this->secretTextCount = $this->size->getWidth() * $height;
        }

        return $this->secretTextCount;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        if (is_null($this->iterator)) {
            $this->iterator = new \ArrayIterator(str_split($this->binary));
        }

        return $this->iterator;
    }

    /**
     * Sets binary string
     *
     * @param SizeInterface $size
     *
     * @throws InvalidArgumentException
     */
    private function setBinary(SizeInterface $size)
    {
        if (!is_null($this->binary)) {
            return;
        }

        $width = $size->getWidth();
        $height = $size->getHeight();

        if ($width > self::MAX_SIZE_VALUE
            || $width <= 0
            || $height > self::MAX_SIZE_VALUE
            || $height < 0
        ) {
            throw new InvalidArgumentException(
                sprintf('Invalid dimension parameters width "%s", height "%s". Width should be in range (0, %s], height [0, %s].',
                    $width, $height, self::MAX_SIZE_VALUE, self::MAX_SIZE_VALUE)
            );
        }

        foreach ([$width, $height] as $item) {
            $this->binary .= sprintf('%016d', decbin($item));
        }
    }
}
