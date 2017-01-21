<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Entity\Memento;

use Picamator\SteganographyKit2\Entity\Api\Memento\PixelMementoFactoryInterface;
use Picamator\SteganographyKit2\Entity\Api\Memento\PixelMementoInterface;
use Picamator\SteganographyKit2\Entity\Api\Memento\PixelOriginatorInterface;
use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;

/**
 * Pixel originator
 *
 * @codeCoverageIgnore
 */
class PixelOriginator implements PixelOriginatorInterface
{
    /**
     * @var ColorInterface
     */
    private $color;

    /**
     * @var PixelMementoFactoryInterface
     */
    private $pixelMementoFactory;

    /**
     * @var PixelMementoInterface
     */
    private $pixelMemento;

    /**
     * @param ColorInterface $color
     * @param PixelMementoFactoryInterface $pixelMementoFactory
     */
    public function __construct(
        ColorInterface $color,
        PixelMementoFactoryInterface $pixelMementoFactory
    ) {
        $this->color = $color;
        $this->pixelMementoFactory = $pixelMementoFactory;
    }

    /**
     * @inheritDoc
     */
    public function setColor(ColorInterface $color): PixelOriginatorInterface
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getColor(): ColorInterface
    {
        return $this->color;
    }

    /**
     * @inheritDoc
     */
    public function saveToMemento(): PixelMementoInterface
    {
        $this->pixelMemento = $this->pixelMementoFactory->create([$this->color]);

        return $this->pixelMemento;
    }

    /**
     * @inheritDoc
     */
    public function getFromMemento(): ColorInterface
    {
        return $this->pixelMemento ? $this->pixelMemento->getColor() : $this->color;
    }
}
