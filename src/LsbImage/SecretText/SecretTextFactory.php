<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\LsbImage\SecretText;

use Picamator\SteganographyKit2\Kernel\Image\Api\ConverterInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create SecretText object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * * Insert ``$secretText`` binary string into image palette
 * * Create ``SecretText``
 *
 * State
 * -----
 * No state
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor argument.
 *
 * Check list
 * ----------
 * * Single responsibility ``-``
 * * Tell don't ask ``+``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
 *
 * @package LsbText\SecretText
 *
 * @codeCoverageIgnore
 */
class SecretTextFactory implements SecretTextFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ImageInterface
     */
    private $image;

    /**
     * @var ChannelInterface
     */
    private $channel;

    /**
     * @var ConverterInterface
     */
    private $converter;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ImageInterface $image
     * @param ChannelInterface $channel
     * @param ConverterInterface $converter
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ImageInterface $image,
        ChannelInterface $channel,
        ConverterInterface $converter,
        string $className = 'Picamator\SteganographyKit2\LsbImage\SecretText\SecretText'
    ) {
        $this->objectManager = $objectManager;
        $this->image = $image;
        $this->channel = $channel;
        $this->converter = $converter;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(string $secretText) : SecretTextInterface
    {
        $this->converter->convert($this->image, $secretText);

        return $this->objectManager->create($this->className, [$this->image, $this->channel]);
    }
}
