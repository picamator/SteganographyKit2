<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Data;

use Picamator\SteganographyKit2\Kernel\Text\Api\Data\LengthInterface;

/**
 * Length value object
 *
 * @package Kernel\Text
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
    private $countBit;

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
    public function getCountBit(): int
    {
        if (is_null($this->countBit)) {
            $this->countBit = $this->getLength() * 8;
        }

        return $this->countBit;
    }
}
