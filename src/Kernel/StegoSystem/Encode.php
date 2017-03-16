<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\StegoSystem;

use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\CoverText\Api\CoverTextInterface;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Api\EncodeBitInterface;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Api\EncodeInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextFactoryInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextInterface;

/**
 * Encode is converting SecretText and CoverText to StegoText
 *
 * Actual algorithm's implementation is concentrated inside CoverText, SecretText, StegoText iterators.
 */
class Encode implements EncodeInterface
{
    /**
     * @var EncodeBitInterface
     */
    private $encodeBit;

    /**
     * @var ColorFactoryInterface
     */
    private $colorFactory;

    /**
     * @var StegoTextFactoryInterface
     */
    private $stegoTextFactory;

    /**
     * @param EncodeBitInterface $encodeBit
     * @param ColorFactoryInterface $colorFactory
     * @param StegoTextFactoryInterface $stegoTextFactory
     */
    public function __construct(
        EncodeBitInterface $encodeBit,
        ColorFactoryInterface $colorFactory,
        StegoTextFactoryInterface $stegoTextFactory
    ) {
        $this->encodeBit = $encodeBit;
        $this->colorFactory = $colorFactory;
        $this->stegoTextFactory = $stegoTextFactory;
    }

    /**
     * @inheritDoc
     */
    public function encode(SecretTextInterface $secretText, CoverTextInterface $coverText): StegoTextInterface
    {
        $iterator = new \MultipleIterator(\MultipleIterator::MIT_NEED_ALL | \MultipleIterator::MIT_KEYS_ASSOC);

        // secret text iterator
        $secretKeyIterator = new \CachingIterator($secretText->getIterator());
        $iterator->attachIterator($secretKeyIterator, 'secretBit');

        // cover text iterator (0) PixelInterface -> (1) ByteInterface
        $coverTextIterator = new \RecursiveIteratorIterator($coverText);
        $iterator->attachIterator($coverTextIterator, 'coverByte');

        foreach ($iterator as $item) {
            // encode bit
            $colorKey = $coverTextIterator->getSubIterator(1)->key();
            $stegoBit = $this->encodeBit->encode($item['secretBit'], $item['coverByte']);

            // update pixel
            if (isset($colorContainer[$colorKey])) {
                $this->updatePixel($coverTextIterator->getSubIterator(0)->current(), $colorContainer);
                $colorContainer = [];
            }

            $colorContainer[$colorKey] = $stegoBit;

            // last iteration
            if (!$secretKeyIterator->hasNext()) {
                $this->updatePixel($coverTextIterator->getSubIterator(0)->current(), $colorContainer);
            }
        }

        return $this->stegoTextFactory->create($coverText->getImage());
    }

    /**
     * Update pixel
     *
     * @param PixelInterface $pixel
     * @param array $data color data
     *
     * @return ColorInterface
     */
    private function updatePixel(PixelInterface $pixel, array $data)
    {
        $data = array_merge($data, $pixel->getColor()->toArray());
        $color = $this->colorFactory->create($data);

        $pixel->setColor($color);
    }
}
