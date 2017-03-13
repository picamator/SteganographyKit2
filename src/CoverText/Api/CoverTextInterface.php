<?php
namespace Picamator\SteganographyKit2\CoverText\Api;

use Picamator\SteganographyKit2\Image\Api\ImageInterface;

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
