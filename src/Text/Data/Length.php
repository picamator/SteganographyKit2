<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Text\Data;

use Picamator\SteganographyKit2\Text\Api\Data\LengthInterface;

/**
 * Length value object
 *
 * @codeCoverageIgnore
 */
class Length implements LengthInterface
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $length;

    /**
     * @var int
     */
    private $lengthBits;

    /**
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * @inheritDoc
     */
    public function getLength(): int
    {
        if (is_null($this->length)) {
            $this->length = strlen($this->text);
        }

        return $this->length;
    }

    /**
     * @inheritDoc
     */
    public function getLengthBits(): int
    {
        if (is_null($this->lengthBits)) {
            $this->lengthBits = $this->getLength() * 8;
        }

        return $this->lengthBits;
    }
}
