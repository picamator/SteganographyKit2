<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Pixel\Data;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Data\NullByte;

/**
 * Null color value object
 *
 * The ``NullByte`` injection is not necessary.
 *
 * Use composition to extend value object. Don't run ``__construct`` directly to modify object.
 * Protection to run ``__construct`` twice was not added for performance reason supposing the client code has height level of trust.
 *
 * @package Kernel\Image
 *
 * @codeCoverageIgnore
 */
final class NullColor implements ColorInterface
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
