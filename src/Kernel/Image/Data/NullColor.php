<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Data;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Data\NullByte;

/**
 * Null color value object
 *
 * The ``NullByte`` construction injection is not necessary for value Null Object
 *
 * @package Kernel\Image
 *
 * @codeCoverageIgnore
 */
class NullColor implements ColorInterface
{
    /**
     * @var ByteInterface
     */
    private $red;

    /**
     * @var ByteInterface
     */
    private $green;

    /**
     * @var ByteInterface
     */
    private $blue;

    /**
     * @var ByteInterface
     */
    private $alpha;

    /**
     * @var string
     */
    private $exportToString;

    /**
     * @var array
     */
    private $exportToArray;

    public function __construct()
    {
        $this->red = $this->green = $this->blue = $this->alpha = new NullByte();
    }

    /**
     * @inheritDoc
     */
    public function getRed() : ByteInterface
    {
        return $this->red;
    }

    /**
     * @inheritDoc
     */
    public function getGreen() : ByteInterface
    {
        return $this->green;
    }

    /**
     * @inheritDoc
     */
    public function getBlue() : ByteInterface
    {
        return $this->blue;
    }

    /**
     * @inheritDoc
     */
    public function getAlpha() : ByteInterface
    {
        return $this->alpha;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        if (is_null($this->exportToString)) {
            $this->exportToString = $this->red->getInt() . $this->green->getInt() . $this->blue->getInt() . $this->alpha->getInt();
        }

        return $this->exportToString;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        if (is_null($this->exportToArray)) {
            $this->exportToArray = [
                'red' => $this->red,
                'green' => $this->green,
                'blue' => $this->blue,
                'alpha' => $this->alpha,
            ];
        }

        return $this->exportToArray;
    }
}
