<?php
namespace Picamator\SteganographyKit2\Kernel\CoverText\Api;

use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;

/**
 * CoverText is an image witch serves as a container for SecretText
 *
 * When CoverText holds SecretText it becomes StegoText in fashion to keep SecretText exposed
 */
interface CoverTextInterface extends \RecursiveIterator
{
    /**
     * Gets image
     *
     * @return ImageInterface
     */
    public function getImage() : ImageInterface;
}
