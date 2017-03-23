<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\SecretText;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\EndMarkInterface;

/**
 * EndMark is an identifier that secret text was ended
 *
 * It prevents to read all cover/stego text.
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * * Iterate over EndMark
 * * EndMark validation
 *
 * State
 * -----
 * * EndMark
 * * EndMark length
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
class EndMark implements EndMarkInterface
{
    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @var int
     */
    private $length;

    /**
     * @var string
     */
    private $endMark;

    /**
     * @param string $endMark as a default 4 bytes string
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $endMark = '11111111000000001111111100000000')
    {
        $this->setEndMark($endMark);
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getBinary(): string
    {
        return $this->endMark;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        if (is_null($this->iterator)) {
            $this->iterator = new \ArrayIterator(str_split($this->endMark));
        }

        return $this->iterator;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        if (is_null($this->length)) {
            $this->length = strlen($this->endMark);
        }

        return $this->length;
    }

    /**
     * Sets EndMark
     *
     * @param string $endMark
     *
     * @throws InvalidArgumentException
     */
    private function setEndMark(string $endMark)
    {
        if (strlen($endMark) % 8 !== 0) {
            throw new InvalidArgumentException(
                sprintf('Invalid endMark "%s" length. EndMark binary string should be divided by 8.', $endMark)
            );
        }

        if (preg_match('/[^01]+/', $endMark) === 1) {
            throw new InvalidArgumentException(
                sprintf('Invalid endMark "%s". EndMark should contain 0 or 1.', $endMark)
            );
        }

        $this->endMark = $endMark;
    }
}
