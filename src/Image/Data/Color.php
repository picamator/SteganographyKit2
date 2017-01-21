<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Image\Data;

use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

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
    private $colorString;

    /**
     * @param OptionsResolverInterface $optionsResolver
     * @param array $options
     */
    public function __construct(OptionsResolverInterface $optionsResolver, array $options)
    {
        $optionsResolver
            ->setDefined('red')
            ->setRequired('red')
            ->setAllowedType('red', 'Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface')

            ->setDefined('green')
            ->setRequired('green')
            ->setAllowedType('green', 'Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface')

            ->setDefined('blue')
            ->setRequired('blue')
            ->setAllowedType('blue', 'Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface')

            ->setDefined('alpha')
            ->setRequired('alpha')
            ->setAllowedType('alpha', 'Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface')
            ->resolve($options);

        $this->red = $optionsResolver->getValue('red');
        $this->green = $optionsResolver->getValue('green');
        $this->blue = $optionsResolver->getValue('blue');
        $this->alpha = $optionsResolver->getValue('alpha');
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
        if (is_null($this->colorString)) {
            $this->colorString = $this->red->getInt() . $this->green->getInt() . $this->blue->getInt() . $this->alpha->getInt();
        }

        return $this->colorString;
    }
}
