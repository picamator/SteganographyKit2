<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\LsbImage\SecretText;

use Picamator\SteganographyKit2\Kernel\Image\Api\Converter\BinaryToImageInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\DecodeInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;

/**
 * Decode SecretText to original resource
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Decode SecretText to resource
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
 * @package LsbText\SecretText
 */
final class Decode implements DecodeInterface
{
    /**
     * @var BinaryToImageInterface
     */
    private $converter;

    /**
     * @param BinaryToImageInterface $converter
     */
    public function __construct(BinaryToImageInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @inheritDoc
     *
     * @return \Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface
     */
    public function decode(SecretTextInterface $secretText)
    {
        $size = $secretText->getInfoMark()->getSize();

        return $this->converter->convert($size, $secretText->getBinaryText());
    }
}
