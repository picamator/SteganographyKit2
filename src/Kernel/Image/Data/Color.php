<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Data;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;

/**
 * Color value object
 *
 * Use factory for building objects to avoid using constructor argument wrong order
 *
 * @codeCoverageIgnore
 */
class Color implements ColorInterface
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

    /**
     * @param ByteInterface $red
     * @param ByteInterface $green
     * @param ByteInterface $blue
     * @param ByteInterface $alpha
     */
    public function __construct(
        ByteInterface $red,
        ByteInterface $green,
        ByteInterface $blue,
        ByteInterface $alpha
    ) {

        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
        $this->alpha = $alpha;
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
                $this->red->getInt(),
                $this->green->getInt(),
                $this->blue->getInt(),
                $this->alpha->getInt(),
            ];
        }

        return $this->exportToArray;
    }
}
