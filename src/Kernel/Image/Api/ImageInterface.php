<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;

/**
 * Image
 */
interface ImageInterface extends \IteratorAggregate
{
    /**
     * Gets path
     *
     * @return string
     */
    public function getPath() : string;

    /**
     * Gets resource
     *
     * @return resource
     */
    public function getResource();

    /**
     * Gets size
     *
     * @return SizeInterface
     */
    public function getSize() : SizeInterface;
}
