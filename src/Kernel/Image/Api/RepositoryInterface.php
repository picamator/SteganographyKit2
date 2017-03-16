<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;

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
