<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Image\Data;

use Picamator\SteganographyKit2\Image\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

/**
 * Size value object
 *
 * @codeCoverageIgnore
 */
class Size implements SizeInterface
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var string
     */
    private $attr;

    /**
     * @var string
     */
    private $bits;

    /**
     * @var int
     */
    private $channels;

    /**
     * @var string
     */
    private $mime;

    /**
     * @param OptionsResolverInterface $optionsResolver
     * @param array $options
     */
    public function __construct(OptionsResolverInterface $optionsResolver, array $options)
    {
        $optionsResolver
            ->setDefined('width')
            ->setRequired('width')
            ->setAllowedType('width', 'int')

            ->setDefined('height')
            ->setRequired('height')
            ->setAllowedType('height', 'int')

            ->setDefined('attr')
            ->setRequired('attr')
            ->setAllowedType('attr', 'string')

            ->setDefined('bits')
            ->setRequired('bits')
            ->setAllowedType('bits', 'string')

            ->setDefined('channels')
            ->setDefault('channels', 0)
            ->setAllowedType('channels', 'int')

            ->setDefined('mime')
            ->setRequired('mime')
            ->setAllowedType('mime', 'string')

            ->resolve($options);

        $this->width = $optionsResolver->getValue('width');
        $this->height = $optionsResolver->getValue('height');
        $this->attr = $optionsResolver->getValue('attr');
        $this->bits = $optionsResolver->getValue('bits');
        $this->channels = $optionsResolver->getValue('channels');
        $this->mime = $optionsResolver->getValue('mime');
    }

    /**
     * @inheritDoc
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @inheritDoc
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @inheritDoc
     */
    public function getAttr(): string
    {
        return $this->attr;
    }

    /**
     * @inheritDoc
     */
    public function getBits(): string
    {
        return $this->bits;
    }

    /**
     * @inheritDoc
     */
    public function getChannels(): int
    {
        return $this->channels;
    }

    /**
     * @inheritDoc
     */
    public function getMime(): string
    {
        return $this->mime;
    }
}
