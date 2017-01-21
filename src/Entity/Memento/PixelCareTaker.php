<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Entity\Memento;

use Picamator\SteganographyKit2\Entity\Api\Memento\PixelCareTakerInterface;
use Picamator\SteganographyKit2\Entity\Api\Memento\PixelMementoInterface;
use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;

/**
 * Pixel care taker
 */
class PixelCareTaker implements PixelCareTakerInterface
{
    /**
     * @var array
     */
    private $mementoList = [];

    /**
     * @var bool
     */
    private $changed = false;

    /**
     * @inheritDoc
     */
    public function add(PixelMementoInterface $memento): PixelCareTakerInterface
    {
        if (empty($this->mementoList)) {
            $this->mementoList[] = $memento;
            return $this;
        }

        /** @var ColorInterface $prevColor */
        $prevColor = current($this->mementoList)->getColor();
        $currColor = $memento->getColor();

        // nothing was changed
        if ($prevColor->toString() === $currColor->toString()) {
            return $this;
        }

        // changes was made
        $this->mementoList[] = $memento;
        $this->changed = true;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getList(): array
    {
        return $this->mementoList;
    }

    /**
     * @inheritDoc
     */
    public function hasChanged(): bool
    {
        return $this->changed;
    }
}
