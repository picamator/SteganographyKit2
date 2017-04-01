<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryInterface;

/**
 * Image
 *
 * @package Kernel\Image
 */
interface ImageInterface extends \IteratorAggregate
{
    /**
     * Gets repository
     *
     * @return RepositoryInterface
     */
    public function getRepository() : RepositoryInterface;

    /**
     * Gets resource
     *
     * @return ResourceInterface
     */
    public function getResource() : ResourceInterface;

    /**
     * Gets info
     *
     * @return InfoInterface
     */
    public function getInfo() : InfoInterface;
}
