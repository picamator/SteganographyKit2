<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Entity\Memento;

use Picamator\SteganographyKit2\Entity\Api\Memento\PixelMementoInterface;
use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;

/**
 * Pixel memento
 *
 * @codeCoverageIgnore
 */
class PixelMemento implements PixelMementoInterface
{
    /**
     * @var ColorInterface
     */
    private $color;

    /**
     * @param ColorInterface $color
     */
    public function __construct(ColorInterface $color)
    {
        $this->color = $color;
    }

    /**
     * @inheritDoc
     */
    public function getColor(): ColorInterface
    {
        return $this->color;
    }
}
