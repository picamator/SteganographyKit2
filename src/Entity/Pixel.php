<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Entity;

use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

/**
 * Pixel entity
 *
 * @codeCoverageIgnore
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

            ->resolve($options);

        $this->point = $optionsResolver->getValue('point');
        $this->color = $optionsResolver->getValue('color');
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
     */
    public function getPoint() : PointInterface
    {
        return $this->point;
    }

    /**
     * @inheritDoc
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
        $this->color = $color;
    }
}
