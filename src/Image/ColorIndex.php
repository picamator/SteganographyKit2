<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Image;

use Picamator\SteganographyKit2\Image\Api\ColorFactoryInterface;
use Picamator\SteganographyKit2\Image\Api\ColorIndexInterface;
use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Primitive\Api\ByteFactoryInterface;
use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;

/**
 * Color index
 *
 * Helps to convert color index to color object and vice versa
 */
class ColorIndex implements ColorIndexInterface
{
    /**
     * @var ByteFactoryInterface
     */
    private $byteFactory;

    /**
     * @var ColorFactoryInterface
     */
    private $colorFactory;

    /**
     * @param ByteFactoryInterface $byteFactory
     * @param ColorFactoryInterface $colorFactory
     */
    public function __construct(ByteFactoryInterface $byteFactory, ColorFactoryInterface $colorFactory)
    {
        $this->byteFactory = $byteFactory;
        $this->colorFactory = $colorFactory;
    }

    /**
     * @inheritDoc
     */
    public function getColor(int $colorIndex): ColorInterface
    {
        $data = [
            'red'   => ($colorIndex >> 16) & 0xFF,
            'green' => ($colorIndex >> 8) & 0xFF,
            'blue'  => $colorIndex & 0xFF,
            'alpha' => ($colorIndex & 0x7F000000) >> 24,
        ];
        $data = array_map([$this, 'createByteCallback'], $data);

        return $this->colorFactory->create($data);
    }

    /**
     * @inheritDoc
     */
    public function getColorallocate(ColorInterface $color): int
    {
        $result = ($color->getRed()->getInt() << 16)
            | ($color->getGreen()->getInt() << 8)
            | $color->getBlue()->getInt();

        return $result;
    }

    /**
     * Create byte callback
     *
     * @param int $colorItem
     *
     * @return ByteInterface
     */
    private function createByteCallback(int $colorItem) : ByteInterface
    {
        return $this->byteFactory->create(decbin($colorItem));
    }
}
