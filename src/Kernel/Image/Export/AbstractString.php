<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\Image\Api\ExportInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;

/**
 * Export image to base64encode string
 *
 * It implements template pattern
 */
abstract class AbstractString implements ExportInterface
{
    /**
     * @var ImageInterface
     */
    private $image;

    /**
     * @param ImageInterface $image
     */
    public function __construct(ImageInterface $image)
    {
        $this->image = $image;
    }

    /**
     * @inheritDoc
     */
    final public function export(): string
    {
        ob_start();
            $result = $this->displayImage($this->image->getResource());
            $contents = ob_get_contents();
        ob_end_clean();

        if ($result === false) {
            throw new RuntimeException(
                sprintf('Failed exporting image "%s"', $this->image->getResource()->getPath())
            );
        }

        return base64_encode($contents);
    }

    /**
     * Display image
     *
     * @param ResourceInterface $resource
     *
     * @return bool
     */
    abstract protected function displayImage(ResourceInterface $resource) : bool;
}
