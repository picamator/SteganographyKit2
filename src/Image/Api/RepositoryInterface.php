<?php
namespace Picamator\SteganographyKit2\Image\Api;

use Picamator\SteganographyKit2\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Exception\RuntimeException;

/**
 * Image Repository
 */
interface RepositoryInterface
{
    /**
     * Update
     *
     * @param PixelInterface $pixel
     *
     * @return void
     *
     * @throws RuntimeException
     */
    public function update(PixelInterface $pixel);
}
