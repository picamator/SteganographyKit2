<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\LsbImage\SecretText;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Image\Api\Converter\ImageToBinaryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\EncodeInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;

/**
 * Encode resource to SecretText
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Encode resource data to binary SecretText
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
 * @package LsbImage\SecretText
 */
final class Encode implements EncodeInterface
{
    /**
     * @var ImageToBinaryInterface
     */
    private $converter;

    /**
     * @var InfoMarkFactoryInterface
     */
    private $infoMarkFactory;

    /**
     * @var SecretTextFactoryInterface
     */
    private $secretTextFactory;

    /**
     * @param ImageToBinaryInterface $converter
     * @param InfoMarkFactoryInterface $infoMarkFactory
     * @param SecretTextFactoryInterface $secretTextFactory
     */
    public function __construct(
        ImageToBinaryInterface $converter,
        InfoMarkFactoryInterface $infoMarkFactory,
        SecretTextFactoryInterface $secretTextFactory
    ) {
        $this->converter = $converter;
        $this->infoMarkFactory = $infoMarkFactory;
        $this->secretTextFactory = $secretTextFactory;
    }

    /**
     * @inheritDoc
     *
     * @param \Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface $data
     */
    public function encode($data): SecretTextInterface
    {
        if (!is_object($data) || !is_a($data, 'Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface')) {
            throw new InvalidArgumentException(
                sprintf('Encoded data type "%s" is not an object or it is not instance of ResourceInterface', gettype($data))
            );
        }

        $encodedText = $this->converter->convert($data);

        $size = $data->getInfo()->getSize();
        $infoMark = $this->infoMarkFactory->create($size->getWidth(), $size->getHeight());

        return $this->secretTextFactory->create($infoMark, $encodedText);
    }
}
