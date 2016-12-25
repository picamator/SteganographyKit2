<?php
namespace Picamator\SteganographyKit2\Primitive\Data;

use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

/**
 * Byte value object
 *
 * @codeCoverageIgnore
 */
class Byte implements ByteInterface
{
    /**
     * @var OptionsResolverInterface
     */
    private $optionsResolver;

    /**
     * @var string
     */
    private $binaryByte;

    /**
     * @var int
     */
    private $intByte;

    /**
     * @param OptionsResolverInterface $optionsResolver
     * @param array $options
     */
    public function __construct(OptionsResolverInterface $optionsResolver, array $options)
    {
        $this->optionsResolver = $optionsResolver;

        $this->optionsResolver
            ->setDefined('byte')
            ->setRequired('byte')
            ->setAllowedType('byte', 'string')
            ->resolve($options);
    }


    /**
     * @inheritDoc
     */
    public function getBinary() : string
    {
        if (is_null($this->binaryByte)) {
            $this->binaryByte = sprintf('%08d', $this->getInt());
        }

        return $this->binaryByte;
    }

    /**
     * @inheritDoc
     */
    public function getInt() : int
    {
        if (is_null($this->intByte)) {
            $this->intByte = decbin($this->optionsResolver->getValue('byte'));
        }

        return $this->intByte;
    }
}
