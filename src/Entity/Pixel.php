<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Entity;

use Picamator\SteganographyKit2\Entity\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

/**
 * Pixel entity
 */
class Pixel implements PixelInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var PointInterface
     */
    private $point;

    /**
     * @var ColorInterface
     */
    private $color;

    /**
     * @var IteratorFactoryInterface
     */
    private $iteratorFactory;

    /**
     * @var bool
     */
    private $changed = false;

    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @param OptionsResolverInterface $optionsResolver
     * @param array $options
     */
    public function __construct(OptionsResolverInterface $optionsResolver, array $options)
    {
        $optionsResolver
            ->setDefined('point')
            ->setRequired('point')
            ->setAllowedType('point', 'Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface')

            ->setDefined('color')
            ->setDefault('color', null)
            ->setAllowedType('color', 'Picamator\SteganographyKit2\Image\Api\Data\ColorInterface')

            ->setDefined('iteratorFactory')
            ->setRequired('iteratorFactory')
            ->setAllowedType('iteratorFactory', 'Picamator\SteganographyKit2\Entity\Api\Iterator\IteratorFactoryInterface')

            ->resolve($options);

        $this->point = $optionsResolver->getValue('point');
        $this->color = $optionsResolver->getValue('color');
        $this->iteratorFactory = $optionsResolver->getValue('iteratorFactory');
    }

    /**
     * @inheritDoc
     */
    public function getId() : string
    {
        if (is_null($this->id)) {
            $this->id = $this->point->getX() . $this->point->getY();
        }

        return $this->id;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getPoint() : PointInterface
    {
        return $this->point;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @inheritDoc
     */
    public function setColor(ColorInterface $color)
    {
        if ($color->toString() !== $this->color->toString()) {
            $this->changed = true;
        }

        $this->color = $color;
    }

    /**
     * @inheritDoc
     */
    public function hasChanged(): bool
    {
        return $this->changed;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        if (is_null($this->iterator)) {
            $this->iterator = $this->iteratorFactory->create($this);
        }

        return $this->iterator;
    }
}
