<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;

/**
 * Image
 */
interface ImageInterface extends \IteratorAggregate
{
    /**
     * Gets resource
     *
     * @return ResourceInterface
     */
    public function getResource() : ResourceInterface;

    /**
     * Gets size
     *
     * @return SizeInterface
     */
    public function getSize() : SizeInterface;
}
